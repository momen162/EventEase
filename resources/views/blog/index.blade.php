@extends('layouts.app')

@section('title', 'Blog')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
@endsection

@section('content')
<div class="blog-page">
<div class="main-content">
  <div class="news-banner">
  <h2>Discover Our Latest News</h2>
</div>


  @if ($blogs->count() > 0)
    {{-- Feature Post --}}
    <div class="feature-post">
      <img src="{{ asset('assets/images/' . $blogs[0]->image) }}" alt="Feature Image">
      <div class="blog-content">
        <h3>{{ $blogs[0]->title }}</h3>
        <p class="blog-snippet">{{ $blogs[0]->short_description }}</p>
        <a href="{{ route('blog.show', $blogs[0]->id) }}" class="read-more-btn">Read More →</a>
      </div>
    </div>
  @endif

  <h2>Our Recent Articles</h2>
  <div class="blog-list">
    @foreach ($blogs->skip(1) as $blog)
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
