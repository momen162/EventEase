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
      @for ($i = 1; $i <= 7; $i++)
        <div class="blog-card">
          <img src="{{ asset('assets/images/blog' . $i . '.jpg') }}" alt="Blog Image {{ $i }}">
          <div class="blog-content">
            <h3>Blog Post Title {{ $i }}</h3>
            <p class="blog-snippet">
              This is a short preview of blog {{ $i }}. Click read more to view the entire article. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
            <p class="blog-full" style="display: none;">
              This is the full content of blog {{ $i }}. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat...
            </p>
            <button class="read-more-btn">Read More</button>
          </div>
        </div>
      @endfor
    </div>
  </div>

  <aside class="sidebar">
    <h3>📈 Most Read Blogs</h3>
    <ul class="most-read">
      <li>Laravel Blade Tips</li>
      <li>Mastering JavaScript</li>
      <li>Responsive Web Design</li>
      <li>PHP 8 New Features</li>
      <li>REST API with Laravel</li>
    </ul>

    <h3>📅 Calendar</h3>
    <div class="calendar-box">
      <p id="today-date"></p>
    </div>
  </aside>
</div>
@endsection

@section('extra-js')
<script src="{{ asset('assets/js/blog.js') }}"></script>
@endsection
