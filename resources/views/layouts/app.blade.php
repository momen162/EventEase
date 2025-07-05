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

  <footer class="footer">
    <div class="footer-content">
      <p>© 2025 EventEase. All rights reserved.</p>
      <p>Follow us on:
        <a href="https://facebook.com/eventease" target="_blank">Facebook</a> |
        <a href="https://twitter.com/eventease" target="_blank">Twitter</a> |
        <a href="https://instagram.com/eventease" target="_blank">Instagram</a>
      </p>
    </div>
    
</body>
</html>
