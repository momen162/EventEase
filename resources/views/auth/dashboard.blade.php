@extends('layouts.app')

@section('title', 'Dashboard')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
@endsection

@section('content')
<section class="dashboard-wrapper">
  <h2>Welcome, {{ $user->name }} 👋</h2>

  <div class="dashboard-info">
    <div class="info-card">
      <h3>User Info</h3>
      <p><strong>Name:</strong> {{ $user->name }}</p>
      <p><strong>Email:</strong> {{ $user->email }}</p>
      <a href="{{ route('profile.edit') }}" class="edit-btn">Edit Profile</a>
    </div>

    <div class="info-card">
      <h3>Purchased Tickets</h3>
      @if(count($tickets ?? []))
        <ul>
          @foreach($tickets as $ticket)
            <li>
              <strong>{{ $ticket->event_name }}</strong> - {{ $ticket->date }} at {{ $ticket->venue }}
            </li>
          @endforeach
        </ul>
      @else
        <p>No tickets purchased yet.</p>
      @endif
    </div>
  </div>
</section>
@endsection
