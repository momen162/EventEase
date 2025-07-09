@extends('layouts.app')

@section('title', $title ?? 'Gallery Details')

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/gallery.css') }}">
@endsection

@section('content')
<section class="gallery-container">
  <h2 class="gallery-title">{{ $title }}</h2>
  <div class="gallery-grid">
    @foreach($images as $img)
    <div class="gallery-item">
      <img src="{{ asset('assets/images/gallery/' . $img) }}" alt="{{ $title }}" class="gallery-img">
    </div>
    @endforeach
  </div>
</section>
@endsection