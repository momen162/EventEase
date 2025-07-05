<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EventEase - @yield('title')</title>
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
  @yield('extra-css')
</head>
<body>
  
  <header>
    <div class="logo">📅 <span>EventEase</span></div>
    <nav>
      <a href="{{ url('/') }}">Home</a>
      <a href="{{ url('/events') }}">Events</a>
      <a href="{{ url('/gallery') }}">Gallery</a>
      <a href="{{ url('/blog') }}">Blog</a>
      <a href="{{ url('/contact') }}">Contact</a>
    </nav>
    <div class="login-section">
      <span>👲🏻 Guest</span>
      <button><a href="{{ url('/login') }}">Login</a></button>
    </div>
  </header>


  
  <main>
    @yield('content')
  </main>

  <script src="{{ asset('assets/js/script.js') }}"></script>
  @yield('extra-js')

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

</body>
</html>
