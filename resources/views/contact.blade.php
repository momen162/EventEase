@extends('layouts.app')

@section('title', 'Contact')

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}">
@endsection

@section('content')
<section class="contact-container">


  {{-- Developer Team Section --}}
  <div class="developer-team">
    <h3>Meet Our Developers</h3>
    <div class="team-grid">
      <!-- Developer 1 -->
      <div class="dev-card">
        <img src="{{ asset('assets/images/Masud.jpg') }}" alt="Dev 1">
        <h4>Masud Rana Mamun</h4>
        <p>Email: mamun15-5451@diu.edu.bd</p>
        <p>Phone: +8801613013536</p>
        <div class="social-links">
          <a href="https://facebook.com/MasudBinMazid" target="_blank" class="social-btn facebook">Facebook</a>
          <a href="https://github.com/MasudBinMazid" target="_blank" class="social-btn github">GitHub</a>
        </div>
      </div>

      <!-- Developer 2 -->
      <div class="dev-card">
        <img src="{{ asset('assets/images/Momen.jpg') }}" alt="Dev 2">
        <h4>Momen Ahmed</h4>
        <p>Email: miah15-4789@diu.edu.bd</p>
        <p>Phone: +8801795516162</p>
        <div class="social-links">
          <a href="https://facebook.com/momen.ahmed.1614460" target="_blank" class="social-btn facebook">Facebook</a>
          <a href="https://github.com/momen162" target="_blank" class="social-btn github">GitHub</a>
        </div>
      </div>

      <!-- Developer 3 -->
      <div class="dev-card">
        <img src="{{ asset('assets/images/Tani.jpg') }}" alt="Dev 3">
        <h4>Zinaat Taslim Tani</h4>
        <p>Email: tani15-5315@diu.edu.bd</p>
        <p>Phone: +8801601950546</p>
        <div class="social-links">
          <a href="https://facebook.com/zinnat.taslim.tani" target="_blank" class="social-btn facebook">Facebook</a>
          <a href="https://github.com/tanizinnat" target="_blank" class="social-btn github">GitHub</a>
        </div>
      </div>

      <!-- Developer 4 -->
      <div class="dev-card">
        <img src="{{ asset('assets/images/Tania.jpg') }}" alt="Dev 4">
        <h4>Tania Tajin</h4>
        <p>Email: tania15-4692@diu.edu.bd</p>
        <p>Phone: +8801906069003</p>
        <div class="social-links">
          <a href="https://facebook.com/tania.tajin.2025" target="_blank" class="social-btn facebook">Facebook</a>
          <a href="https://github.com/taniatajin" target="_blank" class="social-btn github">GitHub</a>
        </div>
      </div>
    </div>
  </div>

  {{-- Success Message --}}
  @if(session('success'))
    <p class="form-status success">{{ session('success') }}</p>
  @endif

  {{-- Validation Errors --}}
  @if ($errors->any())
    <div class="form-status error">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Contact Form --}}

  <h2>Contact Us</h2>


  <form action="{{ route('contact.store') }}" method="POST" class="contact-form" id="contactForm">
    @csrf
    <input type="text" name="name" placeholder="Your Name" value="{{ old('name') }}" required>
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
    <textarea name="message" placeholder="Message..." required>{{ old('message') }}</textarea>
    <button type="submit">Send Message</button>
  </form>
</section>
@endsection

@section('extra-js')
  <script src="{{ asset('assets/js/contact.js') }}"></script>
@endsection
