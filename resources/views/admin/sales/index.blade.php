@extends('admin.layout')
@section('title','Sales (Tickets)')
@section('content')

@php
  $tot = $tot ?? ['tickets_count'=>0,'qty_sum'=>0,'amount_sum'=>0,'amount_paid'=>0];
@endphp

<div class="admin-sales-tickets"><!-- SCOPE WRAPPER -->
  <style>
    .admin-sales-tickets{
      --bg:#ffffff; --surface:#ffffff; --surface-2:#f9fafb; --text:#111827; --muted:#6b7280;
      --border:#e5e7eb; --ring: rgba(37,99,235,.35); --primary:#2563eb; --primary-600:#1d4ed8;
      --radius:16px; --shadow:0 10px 25px -18px rgba(0,0,0,.25); --shadow-sm:0 3px 10px rgba(0,0,0,.06);
    }
    .admin-sales-tickets h2.st-page-title{ margin:0 0 1rem; font-weight:800; letter-spacing:.2px; color:var(--text); }
    .admin-sales-tickets .sa-container{ display:grid; gap:1rem; background:var(--bg); color:var(--text); }
    .admin-sales-tickets .sa-card{ background:var(--surface); border:1px solid rgba(0,0,0,.06); border-radius:var(--radius); box-shadow:var(--shadow); }
    .admin-sales-tickets .sa-card-body{ padding:1rem; }
    .admin-sales-tickets .sa-card-header{ display:flex; align-items:center; justify-content:space-between; padding:.9rem 1rem; border-bottom:1px solid #eef2f7; }
    .admin-sales-tickets .sa-title{ margin:0; font-size:1rem; font-weight:800; letter-spacing:.2px; }
    .admin-sales-tickets .sa-stats{ display:grid; gap:.75rem; grid-template-columns: repeat(4, minmax(0,1fr)); }
    .admin-sales-tickets .sa-stat{ padding:1rem; border-radius:14px; background:var(--surface-2); border:1px solid #eef2f7; box-shadow:var(--shadow-sm); }
    .admin-sales-tickets .sa-stat .k{ font-size:.8rem; color:var(--muted); }
    .admin-sales-tickets .sa-stat .v{ font-size:1.15rem; font-weight:800; margin-top:.2rem; font-variant-numeric:tabular-nums; }
    .admin-sales-tickets .sa-filter .grid{ display:grid; gap:.75rem; grid-template-columns: repeat(6, minmax(0,1fr)); align-items:end; }
    .admin-sales-tickets .sa-filter label{ display:block; font-weight:700; margin-bottom:.35rem; font-size:.9rem; color:#374151; }
    .admin-sales-tickets .sa-input,.admin-sales-tickets .sa-select{ width:100%; border:1px solid var(--border); border-radius:12px; padding:.65rem .75rem; background:#fff; color:var(--text); box-shadow:var(--shadow-sm); }
    .admin-sales-tickets .sa-actions{ display:flex; flex-wrap:wrap; gap:.5rem; }
    .admin-sales-tickets .sa-btn{ appearance:none; border:1px solid transparent; border-radius:999px; padding:.6rem .9rem; font-weight:800; cursor:pointer; background: var(--primary); color:#fff; text-decoration:none; display:inline-flex; align-items:center; }
    .admin-sales-tickets .sa-btn:hover{ background:var(--primary-600); }
    .admin-sales-tickets .sa-btn-ghost{ background:#fff; color:#111827; border:1px solid var(--border); box-shadow:none; }
    .admin-sales-tickets .sa-table-wrap{ overflow:auto; border:1px solid #eef2f7; border-radius:14px; background:var(--surface); }
    .admin-sales-tickets table.sa-table{ width:100%; border-collapse:separate; border-spacing:0; font-size:.95rem; }
    .admin-sales-tickets .sa-table thead th{ position:sticky; top:0; z-index:1; background:#f8fafc; color:#111827; text-align:left; font-weight:800; letter-spacing:.2px; border-bottom:1px solid var(--border); padding:.75rem .75rem; }
    .admin-sales-tickets .sa-table tbody td{ border-bottom:1px solid #f1f5f9; padding:.75rem .75rem; vertical-align:top; }
    .admin-sales-tickets .sa-table tbody tr:nth-child(even){ background:var(--surface-2); }
    .admin-sales-tickets .sa-num{ text-align:right; font-variant-numeric:tabular-nums; }
    .admin-sales-tickets .sa-muted{ color:var(--muted); }
    @media (max-width: 860px){
      .admin-sales-tickets .sa-table, .admin-sales-tickets .sa-table thead, .admin-sales-tickets .sa-table tbody, .admin-sales-tickets .sa-table th, .admin-sales-tickets .sa-table td, .admin-sales-tickets .sa-table tr{ display:block; }
      .admin-sales-tickets .sa-table thead{ display:none; }
      .admin-sales-tickets .sa-table tbody tr{ border-bottom:1px solid var(--border); padding:.5rem .75rem; }
      .admin-sales-tickets .sa-table tbody td{ border:none; padding:.45rem 0; display:grid; grid-template-columns: 140px 1fr; gap:8px; }
      .admin-sales-tickets .sa-table tbody td::before{ content: attr(data-label); font-weight:800; color:var(--muted); }
      .admin-sales-tickets .sa-num{ text-align:left; }
    }
  </style>

  <h2 class="st-page-title">Sales (Tickets)</h2>

  <div class="sa-container">

    <!-- Stats -->
    <div class="sa-stats">
      <div class="sa-stat"><div class="k">Total rows</div><div class="v">{{ (int)($tot['tickets_count'] ?? 0) }}</div></div>
      <div class="sa-stat"><div class="k">Total quantity</div><div class="v">{{ (int)($tot['qty_sum'] ?? 0) }}</div></div>
      <div class="sa-stat"><div class="k">Gross amount</div><div class="v">{{ number_format((float)($tot['amount_sum'] ?? 0), 2) }}</div></div>
      <div class="sa-stat"><div class="k">Paid amount</div><div class="v">{{ number_format((float)($tot['amount_paid'] ?? 0), 2) }}</div></div>
    </div>

    <!-- Filters -->
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

    <!-- Results -->
    <div class="sa-card">
      <div class="sa-card-header">
        <h3 class="sa-title">Results</h3>
        <div style="color:var(--muted); font-size:.9rem;">
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
                <th>Ticket ID</th>
                <th>Code</th>
                <th>Event</th>
                <th>Buyer</th>
                <th class="sa-num">Qty</th>
                <th class="sa-num">Total</th>
                <th>Pay Opt</th>
                <th>Status</th>
                <th>Purchased At</th>
                <th>Action</th> {{-- NEW --}}
              </tr>
            </thead>
            <tbody>
              @foreach ($rows as $r)
                @php
                  $opt = (string) $r->payment_option;
                  $statusBadge = 'status-' . strtolower((string) $r->payment_status);
                @endphp
                <tr>
                  <td data-label="Ticket ID">#{{ $r->id }}</td>
                  <td data-label="Code">{{ $r->ticket_code }}</td>
                  <td data-label="Event">#{{ $r->event_id }} — {{ $r->event_title }}</td>
                  <td data-label="Buyer">
                    {{ $r->buyer_name }}<br>
                    <small class="sa-muted">{{ $r->buyer_email }}@if(!empty($r->buyer_phone)) • {{ $r->buyer_phone }}@endif</small>
                  </td>
                  <td data-label="Qty" class="sa-num">{{ $r->quantity }}</td>
                  <td data-label="Total" class="sa-num">{{ number_format((float) $r->total_amount, 2) }}</td>
                  <td data-label="Pay Opt"><span class="sa-badge {{ $opt === 'pay_later' ? 'pay_later' : 'pay_now' }}">{{ str_replace('_',' ', $opt) }}</span></td>
                  <td data-label="Status"><span class="sa-badge {{ $statusBadge }}">{{ ucfirst($r->payment_status) }}</span></td>
                  <td data-label="Purchased At">{{ \Carbon\Carbon::parse($r->created_at)->format('M d, Y H:i') }}</td>

                  <td data-label="Action">
                    @if ($r->payment_option === 'pay_now' && $r->payment_status === 'unpaid')
                      <form method="POST" action="{{ route('admin.sales.verify', $r->id) }}" onsubmit="return confirm('Mark as paid?')">
                        @csrf
                        <button class="sa-btn" type="submit">Verify Paid</button>
                      </form>
                    @else
                      <span class="sa-muted">—</span>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>

  </div>
</div>
@endsection
