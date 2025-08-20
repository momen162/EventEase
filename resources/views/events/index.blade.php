@extends('layouts.app')
@section('title','Events')
@section('content')
<h1>All Events</h1>
@forelse($events as $event)
  <div>
    <h3><a href="{{ route('events.show',$event) }}">{{ $event->title }}</a></h3>
    <p>{{ $event->starts_at->format('d M Y H:i') }}</p>
    <p>{{ $event->location }}</p>
    <form method="POST" action="{{ route('tickets.start', $event) }}">
      @csrf
      <input type="hidden" name="quantity" value="1">
      <button type="submit">Buy</button>
    </form>
  </div>
@empty
  <p>No events yet.</p>
@endforelse
{{ $events->links() }}
@endsection
