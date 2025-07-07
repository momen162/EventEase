@extends('layouts.app')

@section('title', 'Events')

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/events.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection

@section('content')

<!-- Banner Section -->
<section class="event-banner text-white text-center py-4">
  <h2>Explore Events</h2>
  <p>Explore the Universe of Events at Your Fingertips.</p>
</section>


@endsection

@section('extra-js')
  <script src="{{ asset('assets/js/events.js') }}"></script>
@endsection