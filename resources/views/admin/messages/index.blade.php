@extends('admin.layout')
@section('title','Contact Messages')
@section('content')
<h1>Contact Messages</h1>

@if ($rows->isEmpty())
  <div class="empty">No messages.</div>
@else
<div class="table-wrap">
  <table class="table">
    <thead>
      <tr><th>ID</th><th>Name</th><th>Email</th><th>Received</th><th>Action</th></tr>
    </thead>
    <tbody>
    @foreach ($rows as $r)
      <tr>
        <td>{{ $r->id }}</td>
        <td>{{ $r->name }}</td>
        <td><a href="mailto:{{ $r->email }}">{{ $r->email }}</a></td>
        <td>{{ $r->created_at }}</td>
        <td><a class="btn" href="{{ route('admin.messages.show', $r) }}">View</a></td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>

@if(method_exists($rows,'links'))
  <div style="margin-top:12px">{{ $rows->links() }}</div>
@endif
@endif
@endsection
