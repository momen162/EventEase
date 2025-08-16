@extends('layouts.app')
@section('title', $event->title)

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/events.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
  <a href="{{ route('events.index') }}">&larr; Back to Events</a>

  <h1 class="text-3xl font-bold mt-3">{{ $event->title }}</h1>

  @if($event->banner)
    <img src="{{ $event->banner }}" style="max-width:100%;border-radius:12px;margin:12px 0" alt="">
  @endif

  <p>
    <strong>Date:</strong>
    {{ optional($event->starts_at)->format('M d, Y g:i A') }}
    @if($event->ends_at) - {{ $event->ends_at->format('M d, Y g:i A') }} @endif
  </p>
  <p><strong>Venue:</strong> {{ $event->venue ?? $event->location }}</p>
  <p><strong>Price:</strong> {{ number_format($event->price,2) }}</p>

  <div class="prose mt-4">{!! nl2br(e($event->description)) !!}</div>

  <hr class="my-4">

  {{-- Buy ticket (POST -> tickets.start) with quantity + live total --}}
  <form method="POST" action="{{ route('tickets.start', $event) }}" class="mt-2 space-y-3">
    @csrf

    <div>
      <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
      <input
        type="number"
        name="quantity"
        id="quantity"
        min="1"
        value="1"
        class="mt-1 w-28 rounded-md border-gray-300 py-1.5 px-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
      />
    </div>

    <p class="text-sm">
      <strong>Price:</strong> ${{ number_format($event->price, 2) }}
      × <span id="qtyPreview">1</span>
      = <strong id="totalPreview">${{ number_format($event->price, 2) }}</strong>
    </p>

    <button class="btn register" type="submit">
      <i class="bi bi-box-arrow-in-right"></i> Buy Ticket
    </button>
  </form>

  @guest
    <p style="margin-top:10px;color:#b00">You must log in to purchase.</p>
  @endguest
</div>
@endsection

@section('extra-js')
  <script>
    (function () {
      const price = {{ (float) $event->price }};
      const qtyInput = document.getElementById('quantity');
      const qtyPrev  = document.getElementById('qtyPreview');
      const totPrev  = document.getElementById('totalPreview');

      function recalc() {
        const q = Math.max(1, parseInt(qtyInput.value || '1', 10));
        qtyPrev.textContent = q;
        totPrev.textContent = '$' + (q * price).toFixed(2);
      }
      qtyInput.addEventListener('input', recalc);
      recalc();
    })();
  </script>
@endsection
