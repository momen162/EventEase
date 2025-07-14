@extends('layouts.app')

@section('title', $blog->title)

@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
@endsection

@section('content')
<div class="blog-details">
  <div class="banner">
    <img src="{{ asset('assets/images/' . $blog->image) }}" alt="Blog Banner">
  </div>
  <div class="blog-full-content">
    <h1>{{ $blog->title }}</h1>
    <p class="author">Author: {{ $blog->author }}</p>
    <p>{{ $blog->full_content }}</p>
  </div>
</div>
@endsection
