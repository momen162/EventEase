<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','Admin') • EventEase Admin</title>
  @stack('head')
</head>
<body style="margin:0;font-family:'Segoe UI',sans-serif;background:#f9fafb;color:#333;">
<header class="app-header" style="background:#4a6cf7;color:#fff;padding:0.8rem 0;box-shadow:0 2px 4px rgba(0,0,0,0.05);">
  <div class="wrap header-inner" style="max-width:1100px;margin:0 auto;padding:0 1rem;display:flex;justify-content:space-between;align-items:center;">
    <a href="{{ route('admin.index') }}" class="brand-link" style="font-size:1.3rem;font-weight:bold;color:#fff;text-decoration:none;">EventEase <span style="font-weight:300;">Admin</span></a>
    <nav class="nav" style="display:flex;align-items:center;">
      <a href="{{ route('admin.users.index') }}" style="color:#fff;margin-left:1rem;text-decoration:none;font-weight:500;">Users</a>
      <a href="{{ route('admin.events.index') }}" style="color:#fff;margin-left:1rem;text-decoration:none;font-weight:500;">Events</a>
      <a href="{{ route('admin.requests.index') }}" style="color:#fff;margin-left:1rem;text-decoration:none;font-weight:500;">Requests</a>
      <a href="{{ route('admin.blogs.index') }}" style="color:#fff;margin-left:1rem;text-decoration:none;font-weight:500;">Blogs</a>
      <a href="{{ route('admin.stats.index') }}" style="color:#fff;margin-left:1rem;text-decoration:none;font-weight:500;">Stats</a>
      <a href="{{ route('admin.sales.index') }}" style="color:#fff;margin-left:1rem;text-decoration:none;font-weight:500;">Sales</a>
      <a href="{{ route('admin.sales.events') }}" style="color:#fff;margin-left:1rem;text-decoration:none;font-weight:500;">Sales by Event</a>
      <form method="POST" action="{{ route('logout') }}" style="display:inline;margin-left:1rem;">
        @csrf
        <button class="btn btn-logout" style="background:transparent;border:1px solid #fff;color:#fff;padding:0.3rem 0.6rem;cursor:pointer;border-radius:4px;">Logout</button>
      </form>
    </nav>
  </div>
</header>

<main class="wrap page" style="max-width:1100px;margin:0 auto;padding:2rem 1rem;min-height:70vh;animation:fadeIn 0.4s ease-in-out;">
  @yield('content')
</main>

<footer class="app-footer" style="background:#fff;border-top:1px solid #e5e7eb;padding:1rem 0;text-align:center;font-size:0.9rem;color:#666;">
  <div class="wrap footer-inner" style="max-width:1100px;margin:0 auto;">
    <p>© {{ date('Y') }} EventEase Admin • Developed by <a href="https://your-link-here.com" target="_blank" rel="noopener" style="color:#4a6cf7;text-decoration:none;">Masud</a></p>
  </div>
</footer>

<style>
@keyframes fadeIn {
  from { opacity:0; }
  to { opacity:1; }
}
nav a:hover { opacity:0.85; }
.btn-logout:hover { background:rgba(255,255,255,0.1); }
</style>

@stack('scripts')
</body>
</html>
