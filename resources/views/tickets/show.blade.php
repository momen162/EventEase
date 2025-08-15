@extends('layouts.app')
@section('title','Your Ticket')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
  <h1 class="text-2xl font-bold">Ticket — {{ $ticket->event->title }}</h1>

  <div class="ticket border rounded-xl p-4 mt-4">
    @if($ticket->event->banner)
      <img src="{{ $ticket->event->banner }}" alt="banner" style="width:100%;max-height:260px;object-fit:cover;border-radius:10px">
    @endif

    <p class="mt-3"><strong>When:</strong>
      {{ optional($ticket->event->starts_at)->format('M d, Y g:i A') }}
      @if($ticket->event->ends_at) – {{ $ticket->event->ends_at->format('M d, Y g:i A') }} @endif
    </p>
    <p><strong>Venue:</strong> {{ $ticket->event->venue ?? $ticket->event->location }}</p>
    <p><strong>Quantity:</strong> {{ $ticket->quantity }}</p>
    <p><strong>Status:</strong> {{ ucfirst($ticket->payment_status) }} ({{ str_replace('_',' ', $ticket->payment_option) }})</p>

    <div class="mt-4">
    <strong>QR Code:</strong><br>
    @if($ticket->qr_path)
        {!! file_get_contents(storage_path('app/public/'.$ticket->qr_path)) !!}
    @endif
    <div style="margin-top:6px;font-size:12px">Code: {{ $ticket->ticket_code }}</div>
    </div>
>

    <div class="mt-4">
      <a class="btn view" href="{{ route('tickets.download', $ticket) }}">Download PDF</a>
    </div>
  </div>
</div>
@endsection
