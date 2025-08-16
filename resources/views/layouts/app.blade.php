<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EventEase - @yield('title')</title>

  {{-- Global site CSS (yours) --}}
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/modal.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">

  {{-- Page-level CSS (per-view) --}}
  @yield('extra-css')

  {{-- ✅ Tailwind CDN so utility classes work without Vite --}}
  <script src="https://cdn.tailwindcss.com"></script>
  {{-- Fallback if the CDN above is blocked --}}
  <script>
    if (!window.tailwind) {
      var s = document.createElement('script');
      s.src = 'https://unpkg.com/tailwindcss-cdn@3.4.0/tailwindcss.js';
      document.head.appendChild(s);
    }
  </script>

  {{-- Minimal base in case both CDNs are blocked --}}
  <style>body{background:#f8f9fc;color:#111827}</style>
</head>
<body class="bg-gray-50 text-gray-900">

  <header>
    <div class="logo">📅 <span>EventEase</span></div>

    <div class="hamburger" onclick="toggleMenu()">☰</div>

    <nav id="navMenu">
      <a href="{{ url('/') }}">Home</a>
      <a href="{{ url('/events') }}">Events</a>
      <a href="{{ url('/gallery') }}">Gallery</a>
      <a href="{{ url('/blog') }}">Blog</a>
      <a href="{{ url('/contact') }}">Contact</a>
    </nav>

    <div class="login-section" id="loginSection">
      @guest
        <span>👲🏻 Guest</span>
        <button onclick="openAuthModal()">Login</button>
      @endguest

      @auth
        <div class="dropdown">
          <button class="dropdown-toggle">{{ Auth::user()->name }}</button>
          <div class="dropdown-menu">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit">Logout</button>
            </form>
          </div>
        </div>
      @endauth
    </div>
  </header>

  <main>
    @yield('content')
    @include('components.auth-modal')
  </main>

  <footer class="site-footer">
    <div class="footer-container">
      <div class="footer-column brand">
        <h3>📅 EventEase</h3>
        <p>Your trusted partner for event discovery and ticket booking. Join our community and never miss out again!</p>
      </div>

      <div class="footer-column">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li><a href="{{ url('/events') }}">Events</a></li>
          <li><a href="{{ url('/gallery') }}">Gallery</a></li>
          <li><a href="{{ url('/blog') }}">Blog</a></li>
          <li><a href="{{ url('/contact') }}">Contact</a></li>
          <li><a href="#" id="openTermsModal">Terms & Conditions</a></li>
        </ul>
      </div>

      <div class="footer-column">
        <h4>Follow Us</h4>
        <div class="social-icons">
          <a href="#"><img src="{{ asset('assets/icons/facebook.svg') }}" alt="Facebook"></a>
          <a href="#"><img src="{{ asset('assets/icons/twitter.svg') }}" alt="Twitter"></a>
          <a href="#"><img src="{{ asset('assets/icons/instagram.svg') }}" alt="Instagram"></a>
          <a href="#"><img src="{{ asset('assets/icons/youtube.svg') }}" alt="YouTube"></a>
        </div>
      </div>

      <div class="footer-column">
        <h4>Subscribe</h4>
        <p>Get event updates directly to your inbox.</p>
        <form class="subscribe-form">
          <input type="email" placeholder="Enter your email" />
          <button type="submit">Subscribe</button>
        </form>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; {{ date('Y') }} EventEase. All rights reserved.</p>
    </div>
  </footer>

  {{-- Terms Modal --}}
  <div id="termsModal" class="terms-modal-overlay">
    <div class="terms-modal-content">
      <span class="close-modal" id="closeTermsModal">&times;</span>
      <h2>Terms & Conditions</h2>
      <div class="terms-text">
        <p>Welcome to EventEase. By accessing our platform, you agree to the following terms:</p>

        <h4>1. Use of Service</h4>
        <p>You may use the service for personal, non-commercial purposes only.</p>

        <h4>2. Ticketing Policy</h4>
        <p>Tickets are non-refundable unless the event is cancelled. Always check event details before booking.</p>

        <h4>3. User Responsibilities</h4>
        <p>Keep your account details secure and do not share your password with others.</p>

        <h4>4. Content Ownership</h4>
        <p>All content on this site is owned or licensed by EventEase. Reproduction without permission is prohibited.</p>

        <h4>5. Changes to Terms</h4>
        <p>We reserve the right to update our terms. Please review this section regularly for updates.</p>
      </div>
    </div>
  </div>

  {{-- Global JS --}}
  <script src="{{ asset('assets/js/script.js') }}"></script>
  <script src="{{ asset('assets/js/auth.js') }}"></script>
  <script src="{{ asset('assets/js/modal.js') }}"></script>

  {{-- Page-level JS --}}
  @yield('extra-js')

  <script>
    @if ($errors->any())
      window.onload = function () {
        openAuthModal();
        @if (old('name'))
          switchAuthTab('register');
        @else
          switchAuthTab('login');
        @endif
      }
    @endif
  </script>
</body>
</html>
