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
  <p><strong>Date:</strong> {{ optional($event->starts_at)->format('M d, Y g:i A') }}</p>
  <p><strong>Venue:</strong> {{ $event->venue ?? $event->location }}</p>
  <p><strong>Price:</strong> {{ number_format($event->price,2) }}</p>
  <div class="prose mt-4">{!! nl2br(e($event->description)) !!}</div>
  <form method="POST" action="{{ route('tickets.start', $event) }}" class="mt-2 space-y-3">
    @csrf
    <label for="quantity">Quantity</label>
    <input type="number" name="quantity" id="quantity" min="1" value="1">
    <button type="submit">Buy Ticket</button>
  </form>
</div>
@endsection
@section('extra-js')
<script>
  (function () {
    const price = {{ (float) $event->price }};
    const qtyInput = document.getElementById('quantity');
    qtyInput.addEventListener('input', function() {
      const total = price * Math.max(1, parseInt(qtyInput.value || '1', 10));
      console.log("Total: $" + total.toFixed(2));
    });
  })();
</script>
@endsection

@section('extra-js')
<script>
(function () {
    const price = {{ (float) $event->price }};
    const qtyInput = document.getElementById('quantity');
    const totPrev  = document.getElementById('totalPreview');
    const discount = document.createElement('p');
    discount.id = 'discountPreview';
    qtyInput.parentNode.appendChild(discount);

    function recalc() {
        const q = Math.max(1, parseInt(qtyInput.value || '1', 10));
        totPrev.textContent = (q * price).toFixed(2);
        if(q >= 5){
            discount.textContent = 'Discount Applied: $' + (q * price * 0.1).toFixed(2);
        } else {
            discount.textContent = '';
        }
    }
    qtyInput.addEventListener('input', recalc);
    recalc();
})();
</script>
@endsection
