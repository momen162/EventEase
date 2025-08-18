<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index(Request $r)
    {
        $status  = $r->string('status')->toString();
        $opt     = $r->string('payment_option')->toString();
        $eventId = (int) $r->input('event_id', 0);
        $q       = trim((string) $r->input('q', ''));
        $from    = $r->input('from', '');
        $to      = $r->input('to', '');
        $limit   = min(max((int) $r->input('limit', 200), 10), 2000);

        // Base (filters only) – used for BOTH queries so conditions stay in sync.
        $base = Ticket::query()
            ->join('users',  'users.id',  '=', 'tickets.user_id')
            ->join('events', 'events.id', '=', 'tickets.event_id');

        if (in_array($status, ['unpaid','paid','cancelled'], true)) {
            $base->where('tickets.payment_status', $status);
        }
        if (in_array($opt, ['pay_now','pay_later'], true)) {
            $base->where('tickets.payment_option', $opt);
        }
        if ($eventId > 0) {
            $base->where('tickets.event_id', $eventId);
        }
        if ($q !== '') {
            $base->where(function ($w) use ($q) {
                $w->where('tickets.ticket_code', 'like', "%$q%")
                  ->orWhere('users.name',         'like', "%$q%")
                  ->orWhere('users.email',        'like', "%$q%");
            });
        }
        $from = $r->input('from');
        $to   = $r->input('to');

        if (is_string($from) && trim($from) !== '') {
            $base->whereDate('tickets.created_at', '>=', $from);
        }
        if (is_string($to) && trim($to) !== '') {
            $base->whereDate('tickets.created_at', '<=', $to);
        }
        // 1) ROWS (NO aggregates here)
        $rows = (clone $base)
            ->select([
                'tickets.id',
                'tickets.ticket_code',
                'tickets.quantity',
                'tickets.total_amount',
                'tickets.payment_option',
                'tickets.payment_status',
                'tickets.created_at',
                'events.id   as event_id',
                'events.title as event_title',
                'users.id    as user_id',
                'users.name  as buyer_name',
                'users.email as buyer_email',
                'users.phone as buyer_phone',
            ])
            ->orderByDesc('tickets.created_at')
            ->limit($limit)
            ->get();

        // 2) TOTALS (ONLY aggregates here — no non-aggregated columns)
        $tot = (clone $base)
            ->selectRaw("
                COUNT(*)                                         as tickets_count,
                COALESCE(SUM(tickets.quantity), 0)              as qty_sum,
                COALESCE(SUM(tickets.total_amount), 0)          as amount_sum,
                COALESCE(SUM(CASE WHEN tickets.payment_status='paid' THEN tickets.total_amount ELSE 0 END), 0) as amount_paid
            ")
            ->first();

        $events = Event::select('id', 'title')->orderByDesc('starts_at')->get();

        // Make sure $tot is an array-like structure for the Blade
        $tot = [
            'tickets_count' => (int) ($tot->tickets_count ?? 0),
            'qty_sum'       => (int) ($tot->qty_sum ?? 0),
            'amount_sum'    => (float) ($tot->amount_sum ?? 0),
            'amount_paid'   => (float) ($tot->amount_paid ?? 0),
        ];

        return view('admin.sales.index', compact('rows', 'tot', 'events'));
    }
}
