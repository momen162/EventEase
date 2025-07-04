@extends('layouts.app')

@section('title', 'Contact')

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}">
@endsection

@section('content')
  <h2>Contact Us</h2>
  <form action="#" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Your Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <textarea name="message" placeholder="Message..." required></textarea>
    <button type="submit">Send Message</button>
  </form>
@endsection

@section('extra-js')
  <script src="{{ asset('assets/js/contact.js') }}"></script>
@endsection
