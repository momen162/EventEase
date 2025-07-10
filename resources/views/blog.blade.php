@extends('layouts.app')

@section('title', 'Blog')

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
@endsection

@section('content')
  <section class="blog-container">
    <h2>Latest Blogs</h2>
    <div class="blog-list">
      <div class="blog-card">
        <img src="{{ asset('assets/images/blog1.jpg') }}" alt="Blog Image">
        <div class="blog-content">
          <h3>Understanding Laravel Blade</h3>
          <p class="blog-snippet">Laravel Blade makes templating easier and faster. Learn how to master it for dynamic views.</p>
          <button class="read-more-btn">Read More</button>
        </div>
      </div>

      <div class="blog-card">
        <img src="{{ asset('assets/images/blog2.jpg') }}" alt="Blog Image">
        <div class="blog-content">
          <h3>JavaScript ES6 Tricks</h3>
          <p class="blog-snippet">Explore new ES6 features like arrow functions, template literals, destructuring, and more.</p>
          <button class="read-more-btn">Read More</button>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('extra-js')
  <script src="{{ asset('assets/js/blog.js') }}"></script>
@endsection
