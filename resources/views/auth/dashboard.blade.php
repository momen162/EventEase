@extends('layouts.app')
@section('title', 'Dashboard')

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
  <!-- Inline design tokens + components (scoped) -->
  <style>
    :root{
      --bg: #0b1020;
      --card: rgba(18, 24, 45, 0.7);
      --border: rgba(255,255,255,0.08);
      --muted: #97a3b6;
      --text: #e8ecf3;
      --accent: #7c5cff;
      --accent-2: #34d399; /* green */
      --accent-3: #f59e0b; /* amber */
      --danger: #ef4444;
      --radius: 16px;
      --shadow: 0 10px 30px rgba(0,0,0,0.35);
      --glass: blur(10px) saturate(120%);
    }
    .dash-shell{
      --gap: 1.25rem;
      padding: clamp(16px, 2.2vw, 28px);
      background: radial-gradient(1200px 600px at 10% -10%, rgba(124,92,255,0.20), transparent 60%),
                  radial-gradient(1200px 600px at 110% 20%, rgba(52,211,153,0.18), transparent 60%),
                  var(--bg);
      min-height: calc(100dvh - 80px);
      color: var(--text);
    }
    .dash-topbar{
      display: flex; align-items: center; justify-content: space-between;
      gap: 1rem; margin-bottom: var(--gap);
      padding: 14px 16px;
      border: 1px solid var(--border);
      border-radius: var(--radius);
      background: linear-gradient(180deg, rgba(255,255,255,0.05), rgba(255,255,255,0.02));
      backdrop-filter: var(--glass);
      box-shadow: var(--shadow);
    }
    .dash-welcome{
      font-size: clamp(1.25rem, 2.5vw, 1.6rem);
      font-weight: 700;
      letter-spacing: 0.2px;
    }
    .brand-accent{
      background: linear-gradient(90deg, var(--accent), #9b8bff 40%, #a0f0cf 100%);
      -webkit-background-clip: text; background-clip: text; color: transparent;
    }
    .btn{
      display:inline-flex; align-items:center; justify-content:center; gap:.5rem;
      padding: 10px 14px; border-radius: 999px; font-weight: 600; text-decoration:none;
      transition: transform .15s ease, box-shadow .15s ease, background .2s ease, color .2s ease;
      border: 1px solid var(--border);
      backdrop-filter: var(--glass);
      white-space: nowrap;
    }
    .btn.solid{
      background: linear-gradient(180deg, var(--accent), #5b3dff);
      color: white; border-color: rgba(255,255,255,0.12);
      box-shadow: 0 8px 20px rgba(124,92,255,0.35);
    }
    .btn.ghost{
      background: rgba(255,255,255,0.04); color: var(--text);
    }
    .btn:hover{ transform: translateY(-1px) scale(1.01); }
    .btn:active{ transform: translateY(0); }

    .dash-grid{
      display: grid; gap: var(--gap);
      grid-template-columns: 320px 1fr;
    }
    @media (max-width: 980px){
      .dash-grid{ grid-template-columns: 1fr; }
    }

    /* Card */
    .profile-card, .tickets-panel{
      border: 1px solid var(--border);
      border-radius: calc(var(--radius) + 4px);
      background: linear-gradient(180deg, rgba(255,255,255,0.05), rgba(255,255,255,0.02));
      backdrop-filter: var(--glass);
      box-shadow: var(--shadow);
      overflow: clip;
    }
    .profile-card{ padding: 18px; }
    .tickets-panel{ padding: 0; }

    /* Avatar */
    .avatar{ width: 88px; height: 88px; border-radius: 50%; overflow: hidden; margin-bottom: 12px; border: 2px solid rgba(255,255,255,0.1);}
    .avatar img{ width: 100%; height: 100%; object-fit: cover; display: block; }
    .avatar-fallback{
      width: 88px; height: 88px; border-radius: 50%;
      display:grid; place-items:center; font-weight:800; font-size: 1.5rem;
      background: linear-gradient(135deg, rgba(124,92,255,0.35), rgba(52,211,153,0.35));
      color: #fff; margin-bottom: 12px; box-shadow: inset 0 0 40px rgba(0,0,0,0.25);
      border: 2px solid rgba(255,255,255,0.12);
    }

    .profile-meta{ display: grid; gap: 8px; margin: 10px 0 16px; }
    .meta-line{ display:flex; align-items:center; justify-content:space-between; gap: 10px; padding: 10px 12px; border:1px dashed var(--border); border-radius: 12px; background: rgba(255,255,255,0.03); }
    .meta-label{ color: var(--muted); font-size: .9rem; }
    .meta-value{ font-weight: 600; overflow: hidden; text-overflow: ellipsis; }

    .profile-btn{
      display:inline-flex; align-items:center; gap:.5rem;
      padding: 10px 14px; border-radius: 12px; text-decoration: none; font-weight: 600;
      background: rgba(255,255,255,0.04); border:1px solid var(--border); color: var(--text);
      transition: all .2s ease;
    }
    .profile-btn:hover{ transform: translateY(-1px); background: rgba(255,255,255,0.06); }

    /* Tickets */
    .tickets-head{ padding: 16px 18px; border-bottom: 1px solid var(--border); display:flex; align-items:center; justify-content:space-between; gap:1rem; }
    .tickets-title{ font-size: 1.1rem; font-weight: 700; letter-spacing: .2px; }
    .tickets-list{ list-style: none; margin: 0; padding: 8px; display:grid; gap: 12px; }
    .ticket-card{
      display:grid; gap: 12px; grid-template-columns: 1fr auto;
      padding: 14px; border:1px solid var(--border); border-radius: 14px;
      background: rgba(255,255,255,0.035);
      transition: transform .15s ease, background .2s ease, border-color .2s ease;
    }
    .ticket-card:hover{ transform: translateY(-2px); background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.14);}
    .ticket-main{ display:grid; gap: 10px; }
    .t-line{ display:flex; align-items:center; gap:10px; flex-wrap: wrap; }
    .t-label{ color: var(--muted); width: 84px; font-size:.9rem; }
    .t-value{ font-weight: 600; letter-spacing: .15px; }

    .t-status{
      padding: 4px 10px; border-radius: 999px; font-size: .8rem; letter-spacing:.2px;
      border:1px solid var(--border); background: rgba(255,255,255,0.04);
    }
    /* Status color helpers */
    .status-paid{ background: linear-gradient(180deg, rgba(52,211,153,0.18), rgba(52,211,153,0.08)); border-color: rgba(52,211,153,0.35);}
    .status-pending{ background: linear-gradient(180deg, rgba(245,158,11,0.18), rgba(245,158,11,0.08)); border-color: rgba(245,158,11,0.35);}
    .status-failed,.status-cancelled{ background: linear-gradient(180deg, rgba(239,68,68,0.18), rgba(239,68,68,0.08)); border-color: rgba(239,68,68,0.35);}

    .ticket-actions{ display:flex; align-items:center; gap:10px; }
    .tickets-empty{
      padding: 20px; text-align:center; color: var(--muted);
      border:1px dashed var(--border); border-radius: 14px; background: rgba(255,255,255,0.03);
    }

    /* Subsection headings */
    .subhead{
      font-weight: 700; font-size: 1rem; color: var(--text);
      display:flex; align-items:center; gap:.6rem; margin-bottom: .5rem;
    }

    /* Footer card reuse (Your Event Requests) */
    .section-card{ margin-top: 1.5rem; padding: 16px; }
  </style>
@endsection

@section('content')
<section class="dash-shell">
  <!-- Top bar -->
  <div class="dash-topbar" role="banner">
    <h2 class="dash-welcome">
      Welcome, <span class="brand-accent">{{ $user->name }}</span>
    </h2>
    <a href="{{ route('events.request.create') }}" class="btn solid">
      <!-- plus icon -->
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 5v14M5 12h14" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
      Request a New Event
    </a>
  </div>

  <div class="dash-grid">
    <!-- Left: Profile Card -->
    <aside class="profile-card" aria-label="Profile">
      @if ($user->profile_picture)
        <div class="avatar">
          <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}'s profile picture">
        </div>
      @else
        <div class="avatar-fallback" aria-hidden="true">{{ strtoupper(substr($user->name,0,1)) }}</div>
      @endif

      <div class="subhead">
        <!-- user icon -->
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm7 8a7 7 0 0 0-14 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
        Profile
      </div>

      <div class="profile-meta">
        <p class="meta-line" title="{{ $user->email }}">
          <span class="meta-label">Email</span>
          <span class="meta-value">{{ $user->email }}</span>
        </p>
        <p class="meta-line">
          <span class="meta-label">Phone</span>
          <span class="meta-value">{{ $user->phone ?? 'N/A' }}</span>
        </p>
      </div>

      <a href="{{ route('profile.edit') }}" class="profile-btn">
        <!-- settings icon -->
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 15.5A3.5 3.5 0 1 0 8.5 12 3.5 3.5 0 0 0 12 15.5Z" stroke="currentColor" stroke-width="1.8"/><path d="M19 12a7 7 0 0 0-.09-1.1l2.11-1.64-2-3.46-2.54 1a6.93 6.93 0 0 0-1.9-1.1l-.38-2.7h-4l-.38 2.7a6.93 6.93 0 0 0-1.9 1.1l-2.54-1-2 3.46L5.09 10.9A7 7 0 0 0 5 12a7 7 0 0 0 .09 1.1l-2.11 1.64 2 3.46 2.54-1a6.93 6.93 0 0 0 1.9 1.1l.38 2.7h4l.38-2.7a6.93 6.93 0 0 0 1.9-1.1l2.54 1 2-3.46-2.11-1.64A7 7 0 0 0 19 12Z" stroke="currentColor" stroke-width="1.2"/></svg>
        Manage Profile
      </a>
    </aside>

    <!-- Right: Tickets -->
    <main class="tickets-panel" aria-label="Your Tickets">
      <div class="tickets-head">
        <h3 class="tickets-title">Your Tickets 🎫</h3>
        @if($tickets->count())
          <span class="t-status" aria-label="Ticket count">{{ $tickets->count() }} total</span>
        @endif
      </div>

      <ul class="tickets-list">
        @forelse ($tickets as $ticket)
          @php
            $status = strtolower($ticket->payment_status ?? 'unknown');
            $statusClass = [
              'paid' => 'status-paid',
              'completed' => 'status-paid',
              'success' => 'status-paid',
              'pending' => 'status-pending',
              'processing' => 'status-pending',
              'failed' => 'status-failed',
              'cancelled' => 'status-cancelled',
            ][$status] ?? '';
          @endphp

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
                  — <strong class="t-status {{ $statusClass }}">{{ ucfirst($ticket->payment_status) }}</strong>
                </span>
              </div>
            </div>

            <div class="ticket-actions">
              <a class="btn ghost" href="{{ route('tickets.show', $ticket) }}">
                <!-- eye icon -->
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/></svg>
                View
              </a>
              <a class="btn solid" href="{{ route('tickets.download', $ticket) }}">
                <!-- download icon -->
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3v12m0 0 4-4m-4 4-4-4M4 19h16" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                PDF
              </a>
            </div>
          </li>
        @empty
          <li class="tickets-empty">
            No tickets yet. <a class="btn ghost" style="margin-left:.5rem" href="{{ route('events.request.create') }}">Book your first event</a>
          </li>
        @endforelse
      </ul>
    </main>
  </div>

  <!-- Your Event Requests -->
  <aside class="profile-card section-card" style="margin-top: 1.5rem;">
    <h3 class="subhead">
      <!-- calendar icon -->
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 2v4M17 2v4M3 9h18M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5A2 2 0 0 0 3 7v12a2 2 0 0 0 2 2Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
      Your Event Requests
    </h3>
    @php
      // TODO: move to controller for best practice
      $myEvents = \App\Models\Event::where('created_by', $user->id)->latest()->limit(5)->get();
    @endphp
    <ul class="tickets-list">
      @forelse($myEvents as $ev)
        <li class="ticket-card" aria-label="Event request">
          <div class="ticket-main">
            <div class="t-line"><span class="t-label">Title</span><span class="t-value">{{ $ev->title }}</span></div>
            <div class="t-line"><span class="t-label">Starts</span><span class="t-value">{{ $ev->starts_at?->format('M d, Y H:i') }}</span></div>
            @php
              $evStatus = strtolower($ev->status ?? 'draft');
              $evClass = [
                'approved' => 'status-paid',
                'published' => 'status-paid',
                'pending' => 'status-pending',
                'review' => 'status-pending',
                'rejected' => 'status-failed',
                'cancelled' => 'status-cancelled',
                'draft' => ''
              ][$evStatus] ?? '';
            @endphp
            <div class="t-line">
              <span class="t-label">Status</span>
              <span class="t-value"><strong class="t-status {{ $evClass }}">{{ ucfirst($ev->status) }}</strong></span>
            </div>
          </div>
        </li>
      @empty
        <li class="tickets-empty">
          No event requests yet. Start by
          <a class="btn ghost" style="margin-left:.5rem" href="{{ route('events.request.create') }}">requesting an event</a>.
        </li>
      @endforelse
    </ul>
  </aside>
</section>
@endsection
