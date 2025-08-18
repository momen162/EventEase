@extends('admin.layout')
@section('title','Sales (Tickets)')
@section('content')

@php
  $tot = $tot ?? ['tickets_count'=>0,'qty_sum'=>0,'amount_sum'=>0,'amount_paid'=>0];
@endphp

<h2 style="margin:0 0 1rem;">Sales (Tickets)</h2>

<style>
  .sa-container { display: grid; gap: 1rem; }
  .sa-card { background:#fff; border:1px solid rgba(0,0,0,.06); border-radius:16px; box-shadow:0 10px 25px -18px rgba(0,0,0,.25); }
  .sa-card-body { padding: 1rem; }
  .sa-card-header { display:flex; align-items:center; justify-content:space-between; padding:.9rem 1rem; border-bottom:1px solid #eef2f7; }
  .sa-title { margin:0; font-size:1rem; font-weight:700; letter-spacing:.2px; }
  .sa-stats { display:grid; gap:.75rem; grid-template-columns: repeat(4, minmax(0,1fr)); }
  .sa-stat { padding:1rem; border-radius:14px; background:#f9fafb; border:1px solid #eef2f7; }
  .sa-stat .k { font-size:.8rem; color:#6b7280; }
  .sa-stat .v { font-size:1.15rem; font-weight:800; margin-top:.2rem; font-variant-numeric: tabular-nums; }
  .sa-filter .grid { display:grid; gap:.75rem; grid-template-columns: repeat(6, minmax(0,1fr)); align-items:end; }
  .sa-filter label { display:block; font-weight:600; margin-bottom:.35rem; font-size:.9rem; color:#374151; }
  .sa-input, .sa-select { width:100%; border:1px solid #e5e7eb; border-radius:12px; padding:.65rem .75rem; background:#fff; }
  .sa-actions { display:flex; flex-wrap:wrap; gap:.5rem; }
  .sa-right { justify-self:end; }
  .sa-btn { appearance:none; border:none; border-radius:999px; padding:.7rem 1rem; font-weight:700; cursor:pointer; background: linear-gradient(135deg, #6366f1, #8b5cf6); color:#fff; box-shadow:0 8px 18px -12px rgba(99,102,241,.8); }
  .sa-btn-ghost { background:#fff; color:#111827; border:1px solid #e5e7eb; box-shadow:none; }
  .sa-table-wrap { overflow:auto; border:1px solid #eef2f7; border-radius:14px; }
  table.sa-table { width:100%; border-collapse: collapse; font-size:.95rem; }
  .sa-table thead th { position: sticky; top: 0; z-index: 1; background:#f8fafc; color:#111827; text-align:left; font-weight:700; letter-spacing:.2px; border-bottom:1px solid #e5e7eb; padding:.75rem .75rem; }
  .sa-table tbody td { border-bottom:1px solid #f1f5f9; padding:.75rem .75rem; vertical-align: top; }
  .sa-table tbody tr:hover { background:#fafafa; }
  .sa-num { text-align:right; font-variant-numeric: tabular-nums; }
  .sa-badge { display:inline-flex; align-items:center; gap:.35rem; padding:.35rem .55rem; font-size:.8rem; font-weight:800; border-radius:999px; border:1px solid transparent; text-transform:capitalize; white-space:nowrap; }
  .sa-badge.pay_now { background:#ecfeff; color:#0e7490; border-color:#a5f3fc; }
  .sa-badge.pay_later { background:#fef9c3; color:#854d0e; border-color:#fde68a; text-transform:none; }
  .sa-badge.status-paid { background:#ecfdf5; color:#065f46; border-color:#a7f3d0; }
  .sa-badge.status-unpaid { background:#fff7ed; color:#9a3412; border-color:#fed7aa; }
  .sa-badge.status-cancelled { background:#fee2e2; color:#991b1b; border-color:#fecaca; }
  @media (max-width: 1024px) { .sa-stats { grid-template-columns: repeat(2, minmax(0,1fr)); } .sa-filter .grid { grid-template-columns: repeat(2, minmax(0,1fr)); } }
</style>

<div class="sa-container">

  <div class="sa-stats">
    <div class="sa-stat"><div class="k">Total rows</div><div class="v">{{ (int)($tot['tickets_count'] ?? 0) }}</div></div>
    <div class="sa-stat"><div class="k">Total quantity</div><div class="v">{{ (int)($tot['qty_sum'] ?? 0) }}</div></div>
    <div class="sa-stat"><div class="k">Gross amount</div><div class="v">{{ number_format((float)($tot['amount_sum'] ?? 0), 2) }}</div></div>
    <div class="sa-stat"><div class="k">Paid amount</div><div class="v">{{ number_format((float)($tot['amount_paid'] ?? 0), 2) }}</div></div>
  </div>

  <div class="sa-card sa-filter">
    <div class="sa-card-header">
      <h3 class="sa-title">Filters</h3>
      <div class="sa-actions">
        <a href="{{ route('admin.sales.export', request()->query()) }}" class="sa-btn">Export CSV</a>
      </div>
    </div>
    <div class="sa-card-body">
      <form method="GET" class="grid">
        <div>
          <label>Status</label>
          <select name="status" class="sa-select">
            @php $status = request('status',''); @endphp
            <option value="">All</option>
            @foreach (['unpaid','paid','cancelled'] as $s)
              <option value="{{ $s }}" {{ $status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label>Payment Option</label>
          <select name="payment_option" class="sa-select">
            @php $option = request('payment_option',''); @endphp
            <option value="">All</option>
            @foreach (['pay_now','pay_later'] as $op)
              <option value="{{ $op }}" {{ $option===$op?'selected':'' }}>{{ str_replace('_',' ',$op) }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label>Event</label>
          <select name="event_id" class="sa-select">
            @php $eventId = (int)request('event_id',0); @endphp
            <option value="0">All events</option>
            @foreach ($events as $e)
              <option value="{{ $e->id }}" {{ $eventId===$e->id?'selected':'' }}>#{{ $e->id }} — {{ $e->title }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label>Search</label>
          <input type="text" name="q" class="sa-input" value="{{ request('q','') }}" placeholder="Ticket code, name, email">
        </div>

        <div>
          <label>From</label>
          <input type="date" name="from" class="sa-input" value="{{ request('from','') }}">
        </div>

        <div>
          <label>To</label>
          <input type="date" name="to" class="sa-input" value="{{ request('to','') }}">
        </div>

        <div>
          <label>Limit</label>
          <input type="number" name="limit" class="sa-input" min="10" max="2000" value="{{ (int)request('limit',200) }}">
        </div>

        <div style="grid-column: span 2;">
          <div class="sa-actions">
            <button type="submit" class="sa-btn">Apply Filters</button>
            <a href="{{ route('admin.sales.index') }}" class="sa-btn sa-btn-ghost">Reset</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="sa-card">
    <div class="sa-card-header">
      <h3 class="sa-title">Results</h3>
      <div style="color:#6b7280; font-size:.9rem;">
        {{ (int)($tot['tickets_count'] ?? 0) }} matching row{{ ((int)($tot['tickets_count'] ?? 0) === 1 ? '' : 's') }}
      </div>
    </div>

    @if (empty($rows) || (is_countable($rows) && count($rows)===0))
      <div class="sa-card-body sa-empty">
        <h3>No tickets found</h3>
        <p>Try adjusting your filters or date range.</p>
      </div>
    @else
      <div class="sa-card-body sa-table-wrap">
        <table class="sa-table">
          <thead>
            <tr>
              <th>Ticket ID</th><th>Code</th><th>Event</th><th>Buyer</th>
              <th class="sa-num">Qty</th><th class="sa-num">Total</th><th>Pay Opt</th><th>Status</th><th>Purchased At</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($rows as $r)
  @php
    $opt = (string) $r->payment_option;
    $statusBadge = 'status-' . strtolower((string) $r->payment_status);
  @endphp
  <tr>
    <td>#{{ $r->id }}</td>
    <td>{{ $r->ticket_code }}</td>
    <td>#{{ $r->event_id }} — {{ $r->event_title }}</td>
    <td>
      {{ $r->buyer_name }}<br>
      <small>{{ $r->buyer_email }}@if(!empty($r->buyer_phone)) • {{ $r->buyer_phone }}@endif</small>
    </td>
    <td class="sa-num">{{ $r->quantity }}</td>
    <td class="sa-num">{{ number_format((float) $r->total_amount, 2) }}</td>
    <td><span class="sa-badge {{ $opt === 'pay_later' ? 'pay_later' : 'pay_now' }}">{{ str_replace('_',' ', $opt) }}</span></td>
    <td><span class="sa-badge {{ $statusBadge }}">{{ ucfirst($r->payment_status) }}</span></td>
    <td>{{ \Carbon\Carbon::parse($r->created_at)->format('M d, Y H:i') }}</td>
  </tr>
@endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>

</div>
@endsection
