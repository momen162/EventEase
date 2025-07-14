@extends('layouts.app')

@section('title', 'Blog')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
@endsection

@section('content')
<div class="blog-page">
  <div class="main-content">
    <h2>Latest Blogs</h2>
    <div class="blog-list">
      @foreach ($blogs as $blog)
        <div class="blog-card">
          <img src="{{ asset('assets/images/' . $blog->image) }}" alt="Blog Image">
          <div class="blog-content">
            <h3>{{ $blog->title }}</h3>
            <p class="blog-snippet">{{ $blog->short_description }}</p>
            <a href="{{ route('blog.show', $blog->id) }}" class="read-more-btn">Read More</a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
