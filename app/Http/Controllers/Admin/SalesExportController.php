<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesExportController extends Controller
{
    public function export(Request $r)
    {
        $status  = $r->string('status')->toString();
        $opt     = $r->string('payment_option')->toString();
        $eventId = (int) $r->input('event_id', 0);
        $q       = trim((string) $r->input('q', ''));
        $from    = $r->input('from', '');
        $to      = $r->input('to', '');

        // Same base filters as SalesController@index (DRY but inlined here).
        $base = \App\Models\Ticket::query()
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


        $rowsQ = (clone $base)->select([
            'tickets.id', 'tickets.ticket_code', 'tickets.quantity', 'tickets.total_amount',
            'tickets.payment_option', 'tickets.payment_status', 'tickets.created_at',
            'events.id as event_id', 'events.title as event_title',
            'users.name as buyer_name', 'users.email as buyer_email', 'users.phone as buyer_phone',
        ])->orderByDesc('tickets.created_at');

        return response()->streamDownload(function () use ($rowsQ) {
            $out = fopen('php://output', 'w');
            fputcsv($out, [
                'Ticket ID','Ticket Code','Event ID','Event Title','Buyer Name','Buyer Email','Buyer Phone',
                'Quantity','Total Amount','Payment Option','Payment Status','Purchased At'
            ]);
            foreach ($rowsQ->cursor() as $r) {
                fputcsv($out, [
                    $r->id, $r->ticket_code, $r->event_id, $r->event_title,
                    $r->buyer_name, $r->buyer_email, $r->buyer_phone,
                    $r->quantity, number_format((float)$r->total_amount, 2, '.', ''),
                    $r->payment_option, $r->payment_status, $r->created_at,
                ]);
            }
            fclose($out);
        }, 'sales_export_'.now()->format('Ymd_His').'.csv', [
            'Content-Type' => 'text/csv; charset=utf-8'
        ]);
    }
}
