@extends('layouts.app')

@section('title', 'Gallery')

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/gallery.css') }}">
@endsection

@section('content')
  <h2>Event Gallery</h2>
  <div class="gallery-grid">
    <!-- Images -->
  </div>
@endsection

@section('extra-js')
  <script src="{{ asset('assets/js/gallery.js') }}"></script>
@endsection
