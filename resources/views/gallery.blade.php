
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
      @foreach(range(1, 9) as $i)
        <div class="gallery-item">
          <img src="{{ asset("assets/images/gallery/img$i.jpg") }}" alt="Event Image {{ $i }}" class="gallery-img">
        </div>
      @endforeach
    </div>

    <!-- Lightbox Modal -->
    <div id="lightbox-modal" class="lightbox-modal">
      <span class="close-btn">&times;</span>
      <img class="lightbox-content" id="lightbox-img">
    </div>
  </section>
@endsection

@section('extra-js')
  <script src="{{ asset('assets/js/gallery.js') }}"></script>
@endsection
