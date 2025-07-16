@extends('layouts.app')

@section('title', $blog->title)

@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
@endsection

@section('content')
<div class="blog-details modern-blog-container">
  <div class="blog-banner">
    <img src="{{ asset('assets/images/' . $blog->image) }}" alt="Blog Banner">
  </div>

  <div class="blog-full-content">
    <h1 class="blog-title">{{ $blog->title }}</h1>
    <p class="blog-author">✍️ Author: <strong>{{ $blog->author }}</strong></p>
    <div class="blog-content">
      {!! nl2br(e($blog->full_content)) !!}
    </div>
  </div>
</div>
@endsection