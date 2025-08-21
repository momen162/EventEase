@extends('admin.layout')
@section('title','Payment Received (Manual)')
@section('content')

<div class="admin-sales-tickets">
  <style>
    .admin-sales-tickets .sa-card{background:#fff;border:1px solid #eef2f7;border-radius:16px;box-shadow:0 10px 25px -18px rgba(0,0,0,.25)}
    .admin-sales-tickets .sa-card-header{display:flex;justify-content:space-between;align-items:center;padding:12px 16px;border-bottom:1px solid #eef2f7}
    .admin-sales-tickets .sa-title{margin:0;font-weight:800}
    .admin-sales-tickets .sa-card-body{padding:16px}
    .admin-sales-tickets .sa-actions{display:flex;gap:.5rem}
    .admin-sales-tickets .sa-input,.admin-sales-tickets .sa-select{width:100%;border:1px solid #e5e7eb;border-radius:12px;padding:.6rem .7rem}
    .admin-sales-tickets .sa-btn{appearance:none;border:1px solid transparent;border-radius:999px;padding:.55rem .9rem;font-weight:800;background:#2563eb;color:#fff}
    .admin-sales-tickets .sa-btn-ghost{background:#fff;color:#111827;border:1px solid #e5e7eb}
    .admin-sales-tickets .sa-table-wrap{overflow:auto;border:1px solid #eef2f7;border-radius:14px;background:#fff}
    .admin-sales-tickets table{width:100%;border-collapse:separate;border-spacing:0}
    .admin-sales-tickets thead th{position:sticky;top:0;background:#f8fafc;text-align:left;font-weight:800;padding:.7rem .7rem;border-bottom:1px solid #e5e7eb}
    .admin-sales-tickets tbody td{padding:.7rem .7rem;border-bottom:1px solid #f1f5f9;vertical-align:top}
    .admin-sales-tickets .sa-num{text-align:right;font-variant-numeric:tabular-nums}
    .badge{display:inline-flex;align-items:center;padding:.25rem .5rem;border-radius:999px;border:1px solid #e5e7eb;background:#f9fafb;font-weight:700;font-size:.8rem}
  </style>

  <div class="sa-card">
    <div class="sa-card-header">
      <h3 class="sa-title">Payment Received (Manual) — Pending Verification</h3>
      <div style="color:#6b7280">{{ $rows->total() }} record(s)</div>
    </div>
    <div class="sa-card-body">
      <form method="GET" class="grid" style="display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:.75rem;margin-bottom:12px">
        <label>
          <div style="font-weight:700;margin-bottom:.35rem">Search</div>
          <input class="sa-input" type="text" name="q" value="{{ $q }}" placeholder="Code / name / email / txn / number">
        </label>
        <label>
          <div style="font-weight:700;margin-bottom:.35rem">Event</div>
          <select class="sa-select" name="event_id">
            <option value="0">All</option>
            @foreach($events as $e)
              <option value="{{ $e->id }}" {{ (int)$eventId===$e->id?'selected':'' }}>#{{ $e->id }} — {{ $e->title }}</option>
            @endforeach
          </select>
        </label>
        <div style="display:flex;align-items:end;gap:.5rem">
          <button class="sa-btn" type="submit">Filter</button>
          <a class="sa-btn-ghost sa-btn" href="{{ route('admin.payments.index') }}">Reset</a>
        </div>
      </form>

      <div class="sa-table-wrap">
        <table>
          <thead>
            <tr>
              <th>Ticket</th>
              <th>Event</th>
              <th>Buyer</th>
              <th>Txn / Payer</th>
              <th class="sa-num">Qty</th>
              <th class="sa-num">Total</th>
              <th>Submitted</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($rows as $r)
              <tr>
                <td>#{{ $r->id }}<br><span class="badge">{{ $r->ticket_code }}</span></td>
                <td>#{{ $r->event_id }} — {{ $r->event_title }}</td>
                <td>
                  {{ $r->buyer_name }}<br>
                  <small style="color:#6b7280">{{ $r->buyer_email }}@if($r->buyer_phone) • {{ $r->buyer_phone }}@endif</small>
                </td>
                <td>
                  <div><strong>Txn:</strong> {{ $r->payment_txn_id ?? '—' }}</div>
                  <div><strong>Payer:</strong> {{ $r->payer_number   ?? '—' }}</div>
                </td>
                <td class="sa-num">{{ (int)$r->quantity }}</td>
                <td class="sa-num">{{ number_format((float)$r->total_amount,2) }}</td>
                <td>{{ \Carbon\Carbon::parse($r->created_at)->format('M d, Y H:i') }}</td>
                <td>
                  <form method="POST" action="{{ route('admin.payments.verify', $r->id) }}" onsubmit="return confirm('Mark ticket as PAID?')">
                    @csrf
                    <button class="sa-btn" type="submit">Verify Paid</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="9" style="text-align:center;color:#6b7280;padding:18px">No pending payments.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div style="margin-top:10px">{{ $rows->links() }}</div>
    </div>
  </div>
</div>
@endsection
