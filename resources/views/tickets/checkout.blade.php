@extends('layouts.app')
@section('title','Checkout')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
  <h1 class="text-2xl font-bold">Buy Ticket — {{ $event->title }}</h1>

  <form method="post" action="{{ route('tickets.confirm') }}" style="margin-top:12px">
    @csrf
    <input type="hidden" name="event_id" value="{{ $event->id }}">
    <input type="hidden" name="qty" value="{{ $qty }}">

    <p>Quantity <strong>{{ $qty }}</strong></p>

    <p class="mt-3"><strong>Payment option</strong></p>
    @foreach($allowed as $opt)
      <label style="display:block;margin:4px 0">
        <input type="radio" name="method" value="{{ $opt }}" {{ $loop->first ? 'checked' : '' }}>
        {{ $opt === 'pay_now' ? 'Pay now' : 'Pay later' }}
      </label>
    @endforeach

    <p class="mt-3">
      <strong>Price:</strong> ${{ number_format($event->price, 2) }}
      × {{ $qty }} = <strong>${{ number_format($total, 2) }}</strong>
    </p>

    <button type="submit" class="btn register" style="margin-top:10px">Proceed Checkout</button>
  </form>
</div>
@endsection
