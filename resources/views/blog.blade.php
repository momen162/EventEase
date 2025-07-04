@extends('layouts.app')

@section('title', 'Blog')

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
@endsection

@section('content')
  <h2>Latest Blogs</h2>
  <div class="blog-list">
    <!-- Blog articles -->
  </div>
@endsection

@section('extra-js')
  <script src="{{ asset('assets/js/blog.js') }}"></script>
@endsection
