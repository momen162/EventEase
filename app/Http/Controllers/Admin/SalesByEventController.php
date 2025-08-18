<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesByEventController extends Controller
{
    public function index(Request $r)
    {
        // Filters
        $status = $r->string('status')->toString(); // 'paid' | 'unpaid' | 'cancelled' | 'all' | ''
        $from   = $r->input('from');
        $to     = $r->input('to');

        // Base query: events left-joined with tickets
        $base = DB::table('events as e')
            ->leftJoin('tickets as t', 't.event_id', '=', 'e.id');

        // Optional filters
        if (in_array($status, ['paid','unpaid','cancelled'], true)) {
            $base->where('t.payment_status', $status);
        }
        if (is_string($from) && trim($from) !== '') {
            $base->whereDate('t.created_at', '>=', $from);
        }
        if (is_string($to) && trim($to) !== '') {
            $base->whereDate('t.created_at', '<=', $to);
        }

        // Grouped aggregation (ONLY_FULL_GROUP_BY safe)
        $rows = (clone $base)
            ->selectRaw("
                e.id   as event_id,
                e.title as event_title,
                e.starts_at,
                e.location,
                COUNT(t.id)                                         as tickets_count,
                COALESCE(SUM(t.quantity), 0)                        as qty_sum,
                COALESCE(SUM(t.total_amount), 0)                    as amount_sum
            ")
            ->groupBy('e.id', 'e.title', 'e.starts_at', 'e.location')
            ->orderByDesc('e.starts_at')
            ->get();

        // Totals across all rows (compute in PHP)
        $totals = [
            'tickets' => (int) $rows->sum('tickets_count'),
            'qty'     => (int) $rows->sum('qty_sum'),
            'amount'  => (float) $rows->sum('amount_sum'),
        ];

        return view('admin.sales_events.index', compact('rows', 'totals'));
    }
}
