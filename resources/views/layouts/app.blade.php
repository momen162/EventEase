<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>EventEase - @yield('title')</title>
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/modal.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@yield('extra-css')
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">
<header>
  <div class="logo">í³… <span>EventEase</span></div>
  <nav>
    <a href="{{ url('/') }}">Home</a>
    <a href="{{ url('/events') }}">Events</a>
    <a href="{{ url('/gallery') }}">Gallery</a>
    <a href="{{ url('/contact') }}">Contact</a>
  </nav>
  <div class="login-section">
    @guest
      <span>í±²í¿» Guest</span>
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
<main>@yield('content')</main>
<footer class="site-footer">
  <p>&copy; {{ date('Y') }} EventEase. All rights reserved.</p>
</footer>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script src="{{ asset('assets/js/auth.js') }}"></script>
<script src="{{ asset('assets/js/modal.js') }}"></script>
@yield('extra-js')
</body>
</html>
