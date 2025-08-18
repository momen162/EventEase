@extends('admin.layout')
@section('title','Sales by Event')

@section('content')
<div class="admin-sales-events"><!-- SCOPE WRAPPER -->
  <style>
    /* Page-scoped tokens */
    .admin-sales-events{
      --bg:#ffffff;
      --surface:#ffffff;
      --surface-2:#f9fafb;
      --text:#111827;
      --muted:#6b7280;
      --border:#e5e7eb;
      --ring:rgba(37,99,235,.35);

      --primary:#2563eb;
      --primary-600:#1d4ed8;

      --radius:14px;
      --shadow:0 10px 30px rgba(0,0,0,.06);
      --shadow-sm:0 2px 10px rgba(0,0,0,.05);
    }

    .admin-sales-events .se-wrap{ padding:clamp(12px,1.8vw,20px); background:var(--bg); color:var(--text); }

    .admin-sales-events .se-page-title{ margin:0 0 1rem; font-weight:800; letter-spacing:.2px; }

    .admin-sales-events .se-card{
      background:var(--surface); border:1px solid var(--border); border-radius:var(--radius);
      box-shadow:var(--shadow); margin-bottom:1rem;
    }
    .admin-sales-events .se-card-header{
      display:flex; align-items:center; justify-content:space-between; gap:12px;
      padding:14px 16px; border-bottom:1px solid var(--border);
    }
    .admin-sales-events .se-title{ margin:0; font-weight:800; }
    .admin-sales-events .se-card-body{ padding:16px; }

    /* Buttons */
    .admin-sales-events .se-btn{
      appearance:none; border:1px solid var(--border); border-radius:999px;
      padding:10px 14px; font-weight:700; text-decoration:none; cursor:pointer;
      display:inline-flex; align-items:center; gap:.5rem; transition:.18s ease;
      background:#fff; color:var(--text); box-shadow:var(--shadow-sm);
    }
    .admin-sales-events .se-btn:hover{ transform:translateY(-1px); box-shadow:var(--shadow); }
    .admin-sales-events .se-btn:focus-visible{ outline:3px solid var(--ring); outline-offset:2px; }
    .admin-sales-events .se-btn-primary{ background:var(--primary); color:#fff; border-color:transparent; }
    .admin-sales-events .se-btn-primary:hover{ background:var(--primary-600); }
    .admin-sales-events .se-btn-ghost{ background:var(--surface-2); }

    /* Pills */
    .admin-sales-events .se-pills{ display:flex; gap:.5rem; flex-wrap:wrap; }
    .admin-sales-events .se-pill{
      text-decoration:none; padding:.55rem .85rem; border-radius:999px;
      border:1px solid var(--border); background:#fff; color:var(--text); font-weight:700;
      transition:.15s ease;
    }
    .admin-sales-events .se-pill:hover{ transform:translateY(-1px); box-shadow:var(--shadow-sm); }
    .admin-sales-events .se-pill.active{ background:#e0ecff; border-color:#c7d2fe; color:#1d4ed8; }

    /* Table */
    .admin-sales-events .se-table-wrap{
      border:1px solid var(--border); border-radius:14px; overflow:hidden; background:var(--surface); box-shadow:var(--shadow);
    }
    .admin-sales-events .se-table{ width:100%; border-collapse:separate; border-spacing:0; font-size:.96rem; }
    .admin-sales-events .se-table thead th{
      text-align:left; padding:12px 14px; background:#fff; border-bottom:1px solid var(--border);
      color:var(--muted); font-weight:800;
    }
    .admin-sales-events .se-table tbody td{
      padding:12px 14px; border-bottom:1px solid var(--border); vertical-align:top;
    }
    .admin-sales-events .se-table tbody tr:nth-child(even){ background:var(--surface-2); }
    .admin-sales-events .se-table tbody tr:hover{ background:#fff; }
    .admin-sales-events .num{
      text-align:right; font-variant-numeric:tabular-nums; font-feature-settings:"tnum" 1;
    }
    .admin-sales-events .muted{ color:var(--muted); }

    .admin-sales-events tfoot th{
      padding:12px 14px; background:#fff; border-top:1px solid var(--border); font-weight:800;
    }

    /* Empty */
    .admin-sales-events .se-empty{
      border:1px dashed var(--border); border-radius:12px; background:var(--surface-2);
      padding:22px; color:var(--muted); text-align:center; box-shadow:var(--shadow-sm);
    }

    /* Responsive table */
    @media (max-width: 960px){
      .admin-sales-events .se-table,
      .admin-sales-events .se-table thead,
      .admin-sales-events .se-table tbody,
      .admin-sales-events .se-table th,
      .admin-sales-events .se-table td,
      .admin-sales-events .se-table tr{ display:block; }
      .admin-sales-events .se-table thead{ display:none; }
      .admin-sales-events .se-table tbody tr{ border-bottom:1px solid var(--border); padding:8px 12px; }
      .admin-sales-events .se-table tbody td{
        border:none; padding:8px 0; display:grid; grid-template-columns: 140px 1fr; gap:8px;
      }
      .admin-sales-events .se-table tbody td::before{
        content: attr(data-label); font-weight:700; color:var(--muted);
      }
      .admin-sales-events tfoot th{ display:block; text-align:left; }
    }
  </style>

  <div class="se-wrap">
    <h2 class="se-page-title">Sales by Event</h2>

    <div class="se-card">
      <div class="se-card-header">
        <h3 class="se-title">View totals by status</h3>
        <div class="se-actions">
          <a class="se-btn se-btn-primary" href="{{ route('admin.sales.export', ['group'=>'event','status'=>request('status','paid')]) }}">Export CSV</a>
        </div>
      </div>
      <div class="se-card-body">
        @php $status = request('status','paid'); @endphp
        <div class="se-pills" role="tablist" aria-label="Filter by status">
          @foreach (['paid'=>'Paid','unpaid'=>'Unpaid','cancelled'=>'Cancelled','all'=>'All'] as $key=>$label)
            <a class="se-pill {{ $status===$key?'active':'' }}" href="{{ route('admin.sales.events', ['status'=>$key]) }}">{{ $label }}</a>
          @endforeach
        </div>
      </div>
    </div>

    @if(empty($rows) || (is_countable($rows) && count($rows)===0))
      <div class="se-empty">
        <h3>No events found</h3>
        <p>Try a different status.</p>
      </div>
    @else
      <div class="se-table-wrap" role="region" aria-label="Sales by event table">
        <table class="se-table">
          <thead>
            <tr>
              <th>Event</th>
              <th>Starts</th>
              <th>Location</th>
              <th class="num">Tickets</th>
              <th class="num">Qty</th>
              <th class="num">Total Amount</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($rows as $r)
              <tr>
                <td data-label="Event">#{{ $r->event_id }} — {{ $r->event_title }}</td>
                <td data-label="Starts">{{ \Carbon\Carbon::parse($r->starts_at)->format('M d, Y H:i') }}</td>
                <td data-label="Location" class="muted">{{ $r->location ?? '—' }}</td>
                <td data-label="Tickets" class="num">{{ (int) $r->tickets_count }}</td>
                <td data-label="Qty" class="num">{{ (int) $r->qty_sum }}</td>
                <td data-label="Total Amount" class="num">{{ number_format((float) $r->amount_sum, 2) }}</td>
                <td data-label="Actions">
                  <a class="se-btn se-btn-ghost"
                     href="{{ route('admin.sales.index', [
                        'event_id' => $r->event_id,
                        'status'   => request('status') === 'all' ? '' : request('status')
                     ]) }}">
                     View Tickets
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th colspan="3" style="text-align:right;">Totals</th>
              <th class="num">{{ (int)$totals['tickets'] }}</th>
              <th class="num">{{ (int)$totals['qty'] }}</th>
              <th class="num">{{ number_format((float)$totals['amount'], 2) }}</th>
              <th></th>
            </tr>
          </tfoot>
        </table>
      </div>
    @endif
  </div>
</div>
@endsection
