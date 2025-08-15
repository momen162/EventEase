@extends('layouts.app')
@section('title', $event->title)

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/events.css') }}">
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
  <a href="{{ route('events.index') }}">&larr; Back to Events</a>

  <h1 class="text-3xl font-bold mt-3">{{ $event->title }}</h1>
  @if($event->banner)
    <img src="{{ $event->banner }}" style="max-width:100%;border-radius:12px;margin:12px 0" alt="">
  @endif

  <p><strong>Date:</strong> {{ optional($event->starts_at)->format('M d, Y g:i A') }}
     @if($event->ends_at) - {{ $event->ends_at->format('M d, Y g:i A') }} @endif
  </p>
  <p><strong>Venue:</strong> {{ $event->venue ?? $event->location }}</p>
  <p><strong>Price:</strong> {{ number_format($event->price,2) }}</p>

  <div class="prose mt-4">{!! nl2br(e($event->description)) !!}</div>

  <hr class="my-4">

  <form method="POST" action="{{ route('tickets.start', $event) }}">
    @csrf
    <label>Quantity
      <input type="number" name="quantity" min="1" value="1">
    </label>
    <button class="btn register" type="submit">
      <i class="bi bi-box-arrow-in-right"></i> Buy Ticket
    </button>
  </form>

  @guest
    <p style="margin-top:10px;color:#b00">You must log in to purchase.</p>
  @endguest
</div>
@endsection
