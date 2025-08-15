<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>{{ $ticket->ticket_code }}</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; }
    .wrap { border:1px solid #ddd; padding:16px; }
    .banner { width:100%; height:180px; object-fit:cover; border-radius:8px; }
    .row { margin-top:8px; }
  </style>
</head>
<body>
  <div class="wrap">
    <h2>{{ $ticket->event->title }}</h2>
    @if($ticket->event->banner)
      <img class="banner" src="{{ public_path(ltrim($ticket->event->banner,'/')) }}" alt="banner">
    @endif

    <div class="row"><strong>When:</strong>
      {{ optional($ticket->event->starts_at)->format('M d, Y g:i A') }}
      @if($ticket->event->ends_at) – {{ $ticket->event->ends_at->format('M d, Y g:i A') }} @endif
    </div>
    <div class="row"><strong>Venue:</strong> {{ $ticket->event->venue ?? $ticket->event->location }}</div>
    <div class="row"><strong>Quantity:</strong> {{ $ticket->quantity }}</div>
    <div class="row"><strong>Status:</strong> {{ ucfirst($ticket->payment_status) }} ({{ str_replace('_',' ', $ticket->payment_option) }})</div>
    <div class="row"><strong>Code:</strong> {{ $ticket->ticket_code }}</div>

        <div class="row" style="margin-top:10px">
    @if($ticket->qr_path)
        {!! file_get_contents(storage_path('app/public/'.$ticket->qr_path)) !!}
    @endif
    </div>

    </div>
  </div>
</body>
</html>
