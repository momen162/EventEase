@extends('admin.layout')
@section('title','Pending Event Requests')
@section('content')
<h2>Pending Event Requests</h2>

@if($rows->isEmpty())
  <p>No pending requests.</p>
@else
<div class="table-wrap">
  <table class="table">
    <thead>
      <tr>
        <th>ID</th><th>Title</th><th>When</th><th>Location</th>
        <th>Capacity</th><th>Requested By</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($rows as $r)
        <tr>
          <td>{{ $r->id }}</td>
          <td>{{ $r->title }}</td>
          <td>
            {{ \Carbon\Carbon::parse($r->starts_at)->format('M d, Y H:i') }}
            @if($r->ends_at)
              – {{ \Carbon\Carbon::parse($r->ends_at)->format('M d, Y H:i') }}
            @endif
          </td>
          <td>{{ $r->location ?? '—' }}</td>
          <td>{{ $r->capacity ?? '—' }}</td>
          <td>
            {{ optional($r->creator)->name ?? 'Unknown' }}<br>
            <small>{{ optional($r->creator)->email ?? '' }}</small>
          </td>
          <td style="white-space:nowrap;">
            <form action="{{ route('admin.requests.approve', $r) }}" method="POST" style="display:inline;">
              @csrf
              <button type="submit" class="btn btn-primary">Approve</button>
            </form>
            <form action="{{ route('admin.requests.reject', $r) }}" method="POST" style="display:inline;" onsubmit="return confirm('Reject this request?');">
              @csrf
              <button type="submit" class="btn btn-ghost">Reject</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endif
@endsection
