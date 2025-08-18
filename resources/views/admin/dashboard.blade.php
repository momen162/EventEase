@extends('admin.layout')
@section('title','Dashboard')
@section('content')
<div class="grid">
  <div class="col-12">
    <div class="card">
      <h2>Welcome, {{ auth()->user()->name }}</h2>
      <p class="help">Quick links to common tasks.</p>
      <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:10px">
        <a class="btn btn-primary" href="{{ route('admin.users.index') }}">Manage Users</a>
        <a class="btn btn-primary" href="{{ route('admin.events.index') }}">Manage Events</a>
      </div>
    </div>
  </div>
</div>
@endsection
