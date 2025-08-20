@extends('layouts.app')
@section('title','Checkout')
@section('content')
<h1>Checkout — {{ $event->title }}</h1>
<form method="POST" action="{{ route('tickets.confirm') }}">
  @csrf
  <input type="hidden" name="event_id" value="{{ $event->id }}">
  <input type="hidden" name="qty" value="{{ $qty }}">
  <p>Quantity: {{ $qty }}</p>
  @foreach($allowed as $opt)
    <label>
      <input type="radio" name="method" value="{{ $opt }}" {{ $loop->first?'checked':'' }}>
      {{ $opt==='pay_now'?'Pay now':'Pay later' }}
    </label>
  @endforeach
  <p>Total: ${{ number_format($total,2) }}</p>
  <button type="submit">Proceed</button>
</form>
@endsection
