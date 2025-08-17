@extends('layouts.app')
@section('title','Request an Event')

@section('content')
<section class="container" style="max-width: 820px; margin: 2rem auto;">
  <style>
    .ee-card{background:#fff;border:1px solid rgba(0,0,0,.06);border-radius:16px;box-shadow:0 10px 30px -15px rgba(0,0,0,.25);padding:clamp(1rem,2.5vw,2rem)}
    .ee-title{display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem}
    .ee-title h2{margin:0;font-weight:700;letter-spacing:.2px}
    .ee-grid{display:grid;gap:1rem;grid-template-columns:1fr}
    @media (min-width:720px){.ee-grid-2{grid-template-columns:1fr 1fr}}
    .ee-label{display:block;font-weight:600;margin-bottom:.4rem}
    .ee-required{color:#dc3545;margin-left:.25rem}
    .ee-input,.ee-textarea{width:100%;border:1px solid #e5e7eb;background:#fff;color:#111827;border-radius:12px;padding:.75rem .9rem;outline:none;transition:border-color .15s,box-shadow .15s}
    .ee-input:focus,.ee-textarea:focus{border-color:#6366f1;box-shadow:0 0 0 4px rgba(99,102,241,.15)}
    .ee-help{font-size:.875rem;color:#6b7280;margin-top:.35rem}
    .ee-error{border-color:#dc3545 !important;box-shadow:0 0 0 4px rgba(220,53,69,.12) !important}
    .ee-actions{display:flex;gap:.75rem;align-items:center;justify-content:flex-end;margin-top:1rem}
    .ee-btn{border:none;border-radius:999px;padding:.85rem 1.25rem;font-weight:600;cursor:pointer;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;box-shadow:0 8px 20px -10px rgba(99,102,241,.8);transition:transform .06s ease,box-shadow .15s ease,filter .15s ease}
    .ee-btn:hover{filter:brightness(1.05)}
    .ee-btn:active{transform:translateY(1px)}
    .ee-muted{color:#6b7280;font-size:.925rem}
    .ee-note{background:linear-gradient(180deg,#f9fafb,#f3f4f6);border:1px dashed #d1d5db;border-radius:16px;padding:1rem 1.25rem;margin-top:1.5rem}
    .ee-note h4{margin:0 0 .5rem;font-weight:700}
    .ee-badge{display:inline-flex;align-items:center;gap:.4rem;background:#eef2ff;color:#4338ca;border:1px solid #e0e7ff;font-size:.8rem;padding:.35rem .6rem;border-radius:999px;font-weight:700}
    .ee-alert{border-radius:12px;padding:.9rem 1rem;margin-bottom:1rem}
    .ee-alert-danger{background:#fff1f2;color:#991b1b;border:1px solid #fecdd3}
    .ee-field{display:flex;flex-direction:column}
  </style>

  <div class="ee-card">
    <div class="ee-title">
      <span class="ee-badge">New</span>
      <h2>Request a New Event</h2>
    </div>
    <p class="ee-muted" style="margin-top:-.25rem;">
      Fill out the details below. Fields marked with <span class="ee-required">*</span> are required.
    </p>

    @if ($errors->any())
      <div class="ee-alert ee-alert-danger" role="alert">
        @php($count = $errors->count())
        <strong>We found {{ $count }} {{ $count === 1 ? 'issue' : 'issues' }}:</strong>
        <ul style="margin:.5rem 0 0 1rem;">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('events.request.store') }}" novalidate>
      @csrf

      <div class="ee-grid">
        {{-- Title --}}
        @php($titleHasError = $errors->has('title'))
        <div class="ee-field">
          <label class="ee-label" for="title">Title <span class="ee-required">*</span></label>
          <input
            id="title"
            type="text"
            name="title"
            required
            class="ee-input {{ $titleHasError ? 'ee-error' : '' }}"
            value="{{ old('title') }}"
            aria-invalid="{{ $titleHasError ? 'true' : 'false' }}"
            placeholder="e.g., Tech Summit 2025">
          <div class="ee-help">Keep it short and descriptive (around 80 characters).</div>
          @if($titleHasError)
            <div class="ee-help" style="color:#b91c1c;">{{ $errors->first('title') }}</div>
          @endif
        </div>

        {{-- Description --}}
        @php($descHasError = $errors->has('description'))
        <div class="ee-field">
          <label class="ee-label" for="description">Description</label>
          <textarea
            id="description"
            name="description"
            rows="5"
            class="ee-textarea {{ $descHasError ? 'ee-error' : '' }}"
            placeholder="Tell attendees what to expect, agenda, speakers, etc.">{{ old('description') }}</textarea>
          @if($descHasError)
            <div class="ee-help" style="color:#b91c1c;">{{ $errors->first('description') }}</div>
          @endif
        </div>

        {{-- Location --}}
        @php($locHasError = $errors->has('location'))
        <div class="ee-field">
          <label class="ee-label" for="location">Location</label>
          <input
            id="location"
            type="text"
            name="location"
            class="ee-input {{ $locHasError ? 'ee-error' : '' }}"
            value="{{ old('location') }}"
            placeholder="e.g., Dhaka Conference Hall A">
          @if($locHasError)
            <div class="ee-help" style="color:#b91c1c;">{{ $errors->first('location') }}</div>
          @endif
        </div>

        {{-- Starts / Ends --}}
        <div class="ee-grid ee-grid-2">
          @php($startHasError = $errors->has('starts_at'))
          <div class="ee-field">
            <label class="ee-label" for="starts_at">Starts at <span class="ee-required">*</span></label>
            <input
              id="starts_at"
              type="datetime-local"
              name="starts_at"
              required
              class="ee-input {{ $startHasError ? 'ee-error' : '' }}"
              value="{{ old('starts_at') }}">
            <div class="ee-help">Use local time. We’ll validate that it’s not in the past.</div>
            @if($startHasError)
              <div class="ee-help" style="color:#b91c1c;">{{ $errors->first('starts_at') }}</div>
            @endif
          </div>

          @php($endHasError = $errors->has('ends_at'))
          <div class="ee-field">
            <label class="ee-label" for="ends_at">Ends at</label>
            <input
              id="ends_at"
              type="datetime-local"
              name="ends_at"
              class="ee-input {{ $endHasError ? 'ee-error' : '' }}"
              value="{{ old('ends_at') }}">
            <div class="ee-help">Optional, but recommended to help with scheduling.</div>
            @if($endHasError)
              <div class="ee-help" style="color:#b91c1c;">{{ $errors->first('ends_at') }}</div>
            @endif
          </div>
        </div>

        {{-- Capacity --}}
        @php($capHasError = $errors->has('capacity'))
        <div class="ee-field">
          <label class="ee-label" for="capacity">Capacity</label>
          <input
            id="capacity"
            type="number"
            name="capacity"
            min="1"
            class="ee-input {{ $capHasError ? 'ee-error' : '' }}"
            value="{{ old('capacity') }}"
            placeholder="e.g., 150">
          <div class="ee-help">Leave blank if unknown; you can update later.</div>
          @if($capHasError)
            <div class="ee-help" style="color:#b91c1c;">{{ $errors->first('capacity') }}</div>
          @endif
        </div>
      </div>

      <div class="ee-actions">
        <button class="ee-btn" type="submit">Submit for Review</button>
      </div>
    </form>

    {{-- NOTE & HIGHLIGHTS --}}
    <div class="ee-note" aria-live="polite">
      <h4>Note & Highlights</h4>
      <ul style="margin:.25rem 0 0 1.2rem;">
        @if (Route::has('contact'))
          <li><strong>Event Banner:</strong> Please <a href="{{ route('contact') }}">contact us</a> to add or update the banner artwork.</li>
        @else
          <li><strong>Event Banner:</strong> Please <a href="mailto:support@eventease.local">contact us</a> to add or update the banner artwork.</li>
        @endif
        <li><strong>Ticket Price:</strong> Pricing is configured by our team. Reach out to finalize ticket tiers and currency.</li>
        <li><strong>Confirmation:</strong> Your event will be reviewed. We’ll confirm details via email before it goes live.</li>
      </ul>
    </div>

    <p class="ee-muted" style="margin-top:.75rem;">
      Need help right now? Email <a href="mailto:support@eventease.local">support@eventease.local</a>.
    </p>
  </div>
</section>
@endsection
