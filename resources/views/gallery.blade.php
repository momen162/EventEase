@extends('layouts.app')

@section('title', 'Gallery')

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/gallery.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection

@section('content')
<section class="gallery-container">
  <h2 class="gallery-title">Event Gallery</h2>
  <div class="gallery-grid">
    @php
      $events = [
        ['id' => 1, 'title' => 'Music Festival', 'image' => 'event1.jpg', 'count' => 5],
        ['id' => 2, 'title' => 'Art Exhibition', 'image' => 'event2.jpg', 'count' => 8],
        ['id' => 3, 'title' => 'Tech Conference', 'image' => 'event3.jpg', 'count' => 6],
        ['id' => 4, 'title' => 'Food Carnival', 'image' => 'event4.jpg', 'count' => 7],
        ['id' => 5, 'title' => 'Film Night', 'image' => 'event5.jpg', 'count' => 9],
        ['id' => 6, 'title' => 'Startup Meetup', 'image' => 'event6.jpg', 'count' => 4],
        ['id' => 7, 'title' => 'Book Fair', 'image' => 'event7.jpg', 'count' => 10],
        ['id' => 8, 'title' => 'Dance Show', 'image' => 'event8.jpg', 'count' => 6],
        ['id' => 9, 'title' => 'Drama Performance', 'image' => 'event9.jpg', 'count' => 5],
        ['id' => 10, 'title' => 'Fashion Gala', 'image' => 'event10.jpg', 'count' => 8],
        ['id' => 11, 'title' => 'Science Fair', 'image' => 'event11.jpg', 'count' => 7],
        ['id' => 12, 'title' => 'Photography Expo', 'image' => 'event12.jpg', 'count' => 9],
        ['id' => 13, 'title' => 'Cultural Day', 'image' => 'event13.jpg', 'count' => 6],
        ['id' => 14, 'title' => 'Charity Concert', 'image' => 'event14.jpg', 'count' => 11],
      ];
    @endphp

    @foreach($events as $event)
    <a href="{{ url('gallery/event-' . $event['id']) }}" class="gallery-card">
      <img src="{{ asset('assets/images/gallery/' . $event['image']) }}" alt="{{ $event['title'] }}" class="card-img">
      <div class="card-body">
        <h4 class="card-title">{{ $event['title'] }}</h4>
        <p class="card-count"><i class="fas fa-image"></i> {{ $event['count'] }} Images</p>
      </div>
    </a>
    @endforeach
  </div>
</section>
@endsection
