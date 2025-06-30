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
    <!-- Developer 1 (Featured: top middle) -->
    <div class="dev-card grid-featured">
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
    <div class="dev-card grid-dev2">
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
    <div class="dev-card grid-dev3">
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
    <div class="dev-card grid-dev4">
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

{{-- Commit: Add developer section comments --}}

{{-- Commit: Update contact form placeholders --}}

{{-- Commit: Enhance social links section --}}

{{-- Commit 1: Add developer section comments --}}

{{-- Commit 2: Update contact form placeholder notes --}}

{{-- Commit 3: Enhance social links section with comment --}}

{{-- Commit 4: Add comment for success message section --}}

{{-- Commit 5: Add comment for validation errors section --}}

{{-- Commit 6: Comment for Contact Form header --}}

{{-- Commit 7: Add comment for CSRF token section --}}

{{-- Commit 8: Add placeholder comment for name input --}}

{{-- Commit 9: Add placeholder comment for email input --}}

{{-- Commit 10: Add placeholder comment for message textarea --}}

{{-- Commit 11: Add comment for submit button --}}

{{-- Commit 12: Add comment for end of contact form --}}

{{-- Commit 13: Add comment for section container --}}

{{-- Commit 14: Add comment for developer card grid --}}

{{-- Commit 15: Add comment for developer 1 details --}}

{{-- Commit 16: Add comment for developer 2 details --}}

{{-- Commit 17: Add comment for developer 3 details --}}

{{-- Commit 18: Add comment for developer 4 details --}}

{{-- Commit 19: Add comment for extra-css section --}}

{{-- Commit 20: Add comment for extra-js section --}}

{{-- Commit 1: Add developer section comments --}}

{{-- Commit 2: Update contact form placeholder notes --}}

{{-- Commit 3: Enhance social links section with comment --}}

{{-- Commit 4: Add comment for success message section --}}

{{-- Commit 5: Add comment for validation errors section --}}

{{-- Commit 6: Comment for Contact Form header --}}

{{-- Commit 7: Add comment for CSRF token section --}}

{{-- Commit 8: Add placeholder comment for name input --}}

{{-- Commit 9: Add placeholder comment for email input --}}

{{-- Commit 10: Add placeholder comment for message textarea --}}

{{-- Commit 11: Add comment for submit button --}}

{{-- Commit 12: Add comment for end of contact form --}}

{{-- Commit 13: Add comment for section container --}}

{{-- Commit 14: Add comment for developer card grid --}}

{{-- Commit 15: Add comment for developer 1 details --}}

{{-- Commit 16: Add comment for developer 2 details --}}
