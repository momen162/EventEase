@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
  <a href="{{ route('events.index') }}">&larr; Back to Events</a>

  <h1 class="text-3xl font-bold mt-3">{{ $event->title }}</h1>

  @if($event->banner_path)
    <img src="{{ $event->banner_path ? (Str::startsWith($event->banner_path,'http') ? $event->banner_path : asset($event->banner_path)) : '' }}"
         alt="Banner" style="max-width:100%;border-radius:12px;margin:16px 0;">
  @endif

  <p>
    <strong>When:</strong>
    {{ optional($event->starts_at)->format('M d, Y g:i A') }}
    @if($event->ends_at) – {{ $event->ends_at->format('M d, Y g:i A') }} @endif
  </p>
  <p><strong>Where:</strong> {{ $event->location }}</p>
  <p><strong>Price:</strong> ${{ number_format($event->price,2) }}</p>

  @if($event->description)
    <div style="margin-top:12px;">{!! nl2br(e($event->description)) !!}</div>
  @endif

  <div style="margin-top:16px;">
    <a class="btn register" href="{{ route('tickets.start', $event) }}">Buy Ticket</a>
  </div>
</div>
@endsection
