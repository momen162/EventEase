@extends('layouts.app')
@section('title',$event->title)
@section('content')
<h1>{{ $event->title }}</h1>
<p><strong>Date:</strong> {{ $event->starts_at->format('d M Y H:i') }}
@if($event->ends_at) - {{ $event->ends_at->format('d M Y H:i') }} @endif</p>
<p><strong>Location:</strong> {{ $event->location }}</p>
<p>{{ $event->description }}</p>
<form method="POST" action="{{ route('tickets.start', $event) }}">
  @csrf
  <input type="hidden" name="quantity" value="1">
  <button type="submit">Buy Ticket</button>
</form>
@endsection
