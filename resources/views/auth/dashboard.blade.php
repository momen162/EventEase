@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section class="dashboard-wrapper">
  <h2>Welcome, {{ $user->name }}</h2>

  @if ($user->profile_picture)
    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" width="100">
  @endif

  <p>Email: {{ $user->email }}</p>
  <p>Phone: {{ $user->phone ?? 'N/A' }}</p>

  <a href="{{ route('profile.edit') }}">Edit Profile</a>

  <h3>Your Tickets</h3>
  <ul>
    @forelse ($tickets as $ticket)
      <li>
        Event: {{ $ticket->event_name ?? 'Unknown' }} <br>
        Date: {{ $ticket->created_at->format('M d, Y') }} <br>
        Status: {{ $ticket->status ?? 'Confirmed' }}
      </li>
    @empty
      <li>No tickets found.</li>
    @endforelse
  </ul>
</section>

@endsection
