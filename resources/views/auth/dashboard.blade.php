@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
@endsection
<section class="dashboard-wrapper">
  <h2 class="dashboard-title">Welcome, <span class="highlight">{{ $user->name }}</span></h2>

  @if ($user->profile_picture)
    <div class="profile-picture">
      <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture">
    </div>
  @endif

  <div class="user-info">
    <p>📧 <strong>Email:</strong> {{ $user->email }}</p>
    <p>📞 <strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
  </div>

  <a href="{{ route('profile.edit') }}" class="edit-profile-btn">Edit Profile</a>

  <h3 class="ticket-title">Your Tickets 🎫</h3>
  <ul class="ticket-list">
    @forelse ($tickets as $ticket)
      <li class="ticket-item">
        <p>🎉 <strong>Event:</strong> {{ $ticket->event_name ?? 'Unknown' }}</p>
        <p>📅 <strong>Date:</strong> {{ $ticket->created_at->format('M d, Y') }}</p>
        <p>✅ <strong>Status:</strong> {{ $ticket->status ?? 'Confirmed' }}</p>
      </li>
    @empty
      <li class="no-ticket">No tickets found.</li>
    @endforelse
  </ul>
</section>
@endsection
