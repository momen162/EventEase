@extends('layouts.app')

@section('title', 'Events')

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/events.css') }}">
@endsection

@section('content')
  <h2>Upcoming Events</h2>
  <div class="event-list">
    <!-- Loop events -->
  </div>
@endsection

@section('extra-js')
  <script src="{{ asset('assets/js/events.js') }}"></script>
@endsection
