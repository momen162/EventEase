<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        $events = DB::table('events as e')
            ->leftJoin('tickets as t','t.event_id','=','e.id')
            ->selectRaw("
              e.id, e.title,
              COALESCE(SUM(t.quantity),0) as tickets_created,
              COALESCE(SUM(CASE WHEN t.payment_status='paid' THEN t.quantity ELSE 0 END),0) as tickets_sold,
              COALESCE(COUNT(DISTINCT CASE WHEN t.payment_status='paid' THEN t.user_id END),0) as unique_buyers
            ")->groupBy('e.id','e.title')->orderByDesc('e.starts_at')->get();

        $labels  = $events->pluck('title');
        $created = $events->pluck('tickets_created')->map(fn($v)=>(int)$v);
        $sold    = $events->pluck('tickets_sold')->map(fn($v)=>(int)$v);

        $top = $events->sortByDesc('tickets_sold')->take(10)->values();

        return view('admin.stats.index', compact('events','labels','created','sold','top'));
    }
}
