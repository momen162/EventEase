@extends('layouts.app')
@section('title', 'Dashboard')

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
@endsection

@section('content')
<section class="dash-shell">
  <!-- Top bar -->
  <div class="dash-topbar">
    <h2 class="dash-welcome">Welcome, <span class="brand-accent">{{ $user->name }}</span></h2>
    <a href="{{ route('events.request.create') }}" class="btn solid">Request a New Event</a>
  </div>

  <div class="dash-grid">
    <!-- Left: Profile Card -->
    <aside class="profile-card">
      @if ($user->profile_picture)
        <div class="avatar">
          <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture">
        </div>
      @else
        <div class="avatar avatar-fallback" aria-hidden="true">{{ strtoupper(substr($user->name,0,1)) }}</div>
      @endif

      <div class="profile-meta">
        <p class="meta-line">
          <span class="meta-label">Email</span>
          <span class="meta-value">{{ $user->email }}</span>
        </p>
        <p class="meta-line">
          <span class="meta-label">Phone</span>
          <span class="meta-value">{{ $user->phone ?? 'N/A' }}</span>
        </p>
      </div>

      <a href="{{ route('profile.edit') }}" class="profile-btn">Manage Profile</a>
    </aside>

    <!-- Right: Tickets -->
    <main class="tickets-panel">
      <div class="tickets-head">
        <h3 class="tickets-title">Your Tickets 🎫</h3>
      </div>

      <ul class="tickets-list">
        @forelse ($tickets as $ticket)
          <li class="ticket-card">
            <div class="ticket-main">
              <div class="t-line">
                <span class="t-label">Event</span>
                <span class="t-value">{{ $ticket->event->title ?? 'Unknown' }}</span>
              </div>
              <div class="t-line">
                <span class="t-label">Date</span>
                <span class="t-value">{{ $ticket->created_at->format('M d, Y') }}</span>
              </div>
              <div class="t-line">
                <span class="t-label">Payment</span>
                <span class="t-value">
                  {{ str_replace('_',' ', $ticket->payment_option) }}
                  — <strong class="t-status">{{ ucfirst($ticket->payment_status) }}</strong>
                </span>
              </div>
            </div>

            <div class="ticket-actions">
              <a class="btn ghost" href="{{ route('tickets.show', $ticket) }}">View Ticket</a>
              <a class="btn solid" href="{{ route('tickets.download', $ticket) }}">Download PDF</a>
            </div>
          </li>
        @empty
          <li class="tickets-empty">No tickets found.</li>
        @endforelse
      </ul>
    </main>
  </div>

  <!-- Your Event Requests -->
  <aside class="profile-card" style="margin-top: 1.5rem;">
    <h3>Your Event Requests</h3>
    @php
      $myEvents = \App\Models\Event::where('created_by', $user->id)->latest()->limit(5)->get();
    @endphp
    <ul class="tickets-list">
      @forelse($myEvents as $ev)
        <li class="ticket-card">
          <div class="ticket-main">
            <div class="t-line"><span class="t-label">Title</span><span class="t-value">{{ $ev->title }}</span></div>
            <div class="t-line"><span class="t-label">Starts</span><span class="t-value">{{ $ev->starts_at?->format('M d, Y H:i') }}</span></div>
            <div class="t-line"><span class="t-label">Status</span>
              <span class="t-value"><strong class="t-status">{{ ucfirst($ev->status) }}</strong></span>
            </div>
          </div>
        </li>
      @empty
        <li class="tickets-empty">No event requests yet.</li>
      @endforelse
    </ul>
  </aside>
</section>
@endsection
