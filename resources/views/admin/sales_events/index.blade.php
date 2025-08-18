@extends('admin.layout')
@section('title','Sales by Event')
@section('content')
<h2 style="margin:0 0 1rem;">Sales by Event</h2>

<div class="card" style="margin-bottom:1rem;">
  <div class="se-card-header" style="display:flex; align-items:center; justify-content:space-between;">
    <h3 class="se-title" style="margin:0;">View totals by status</h3>
    <div class="se-actions">
      <a class="btn btn-primary" href="{{ route('admin.sales.export', ['group'=>'event','status'=>request('status','paid')]) }}">Export CSV</a>
    </div>
  </div>
  <div class="se-card-body" style="padding:1rem;">
    @php $status = request('status','paid'); @endphp
    <div class="se-pills" style="display:flex; gap:.5rem; flex-wrap:wrap;">
      @foreach (['paid'=>'Paid','unpaid'=>'Unpaid','cancelled'=>'Cancelled','all'=>'All'] as $key=>$label)
        <a class="se-pill {{ $status===$key?'active':'' }}" style="text-decoration:none; padding:.55rem .85rem; border-radius:999px; border:1px solid #e5e7eb;"
           href="{{ route('admin.sales.events', ['status'=>$key]) }}">{{ $label }}</a>
      @endforeach
    </div>
  </div>
</div>

@if(empty($rows) || (is_countable($rows) && count($rows)===0))
  <div class="se-card-body se-empty">
    <h3>No events found</h3>
    <p>Try a different status.</p>
  </div>
@else
  <div class="se-card-body se-table-wrap" style="border:1px solid #eef2f7; border-radius:14px;">
    <table class="se-table" style="width:100%; border-collapse: collapse;">
      <thead>
        <tr>
          <th>Event</th><th>Starts</th><th>Location</th>
          <th style="text-align:right;">Tickets</th>
          <th style="text-align:right;">Qty</th>
          <th style="text-align:right;">Total Amount</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
@foreach ($rows as $r)
  <tr>
    <td>#{{ $r->event_id }} — {{ $r->event_title }}</td>
    <td>{{ \Carbon\Carbon::parse($r->starts_at)->format('M d, Y H:i') }}</td>
    <td style="color:#6b7280">{{ $r->location ?? '—' }}</td>
    <td style="text-align:right;">{{ (int) $r->tickets_count }}</td>
    <td style="text-align:right;">{{ (int) $r->qty_sum }}</td>
    <td style="text-align:right;">{{ number_format((float) $r->amount_sum, 2) }}</td>
    <td>
      <a class="btn btn-ghost"
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
          <th style="text-align:right;">{{ (int)$totals['tickets'] }}</th>
          <th style="text-align:right;">{{ (int)$totals['qty'] }}</th>
          <th style="text-align:right;">{{ number_format((float)$totals['amount'], 2) }}</th>
          <th></th>
        </tr>
      </tfoot>
    </table>
  </div>
@endif
@endsection
