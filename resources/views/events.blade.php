@extends('layouts.app')

@section('title', 'Events')

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/events.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection

@section('content')

<!-- Banner Section -->
<section class="event-banner text-white text-center py-4">
  <h2>Explore Events</h2>
  <p>Explore the Universe of Events at Your Fingertips.</p>
</section>


<!-- Filter/Search -->
<section class="filter-search-wrapper">
  <div class="filter-options">
    <label><input type="radio" name="eventStatus" checked> All</label>
    <label><input type="radio" name="eventStatus"> Live</label>
    <label><input type="radio" name="eventStatus"> Upcoming</label>
  </div>
  <div class="search-box">
    <button><i class="bi bi-sliders" id="filter"></i></button>
    <input type="text" placeholder="Search Events..">
    <i class="bi bi-search search-icon"></i>
  </div>
</section>


<!-- Event Cards -->
<section class="event-cards">
  <div class="event-card">
    <div class="card-header purple-gradient">
      <h3>JavaScript Workshop</h3>
      <span class="badge ongoing">ongoing</span>
    </div>
    <div class="card-body">
      <p><i class="bi bi-calendar"></i> 28/02/2024 at 14:00</p>
      <p><i class="bi bi-geo-alt"></i> Learning Hub, Downtown</p>
      <p><i class="bi bi-people"></i> 42/50 &nbsp;&nbsp; <i class="bi bi-clock"></i> 4h</p>
      <p><i class="bi bi-currency-dollar"></i> 99.99</p>
      <p class="description">Hands-on workshop covering modern JavaScript frameworks and best practices.</p>
      <div class="btn-group">
        <button class="btn view"><i class="bi bi-eye"></i> View Details</button>
        <button class="btn register"><i class="bi bi-box-arrow-in-right"></i> Register</button>
      </div>
    </div>
  </div>

  <div class="event-card">
    <div class="card-header purple-gradient">
      <h3>Networking Mixer</h3>
      <span class="badge completed">completed</span>
    </div>
    <div class="card-body">
      <p><i class="bi bi-calendar"></i> 10/02/2024 at 18:00</p>
      <p><i class="bi bi-geo-alt"></i> Rooftop Lounge, Business District</p>
      <p><i class="bi bi-people"></i> 87/100 &nbsp;&nbsp; <i class="bi bi-clock"></i> 3h</p>
      <p><i class="bi bi-currency-dollar"></i> Free</p>
      <p class="description">Professional networking event for entrepreneurs and business leaders.</p>
    <div class="btn-group">
        <button class="btn view"><i class="bi bi-eye"></i> View Details</button>
        <button class="btn register"><i class="bi bi-box-arrow-in-right"></i> Register</button>
      </div>
    </div>
  </div>

  <div class="event-card">
    <div class="card-header purple-gradient">
      <h3>Tech Conference 2024</h3>
      <span class="badge upcoming">upcoming</span>
    </div>
    <div class="card-body">
      <p><i class="bi bi-calendar"></i> 15/03/2024 at 09:00</p>
      <p><i class="bi bi-geo-alt"></i> Convention Center, Tech City</p>
      <p><i class="bi bi-people"></i> 245/500 &nbsp;&nbsp; <i class="bi bi-clock"></i> 8h</p>
      <p><i class="bi bi-currency-dollar"></i> 199.99</p>
      <p class="description">Annual tech conference with sessions on AI, cloud computing, and more.</p>
      <div class="btn-group">
        <button class="btn view"><i class="bi bi-eye"></i> View Details</button>
        <button class="btn register"><i class="bi bi-box-arrow-in-right"></i> Register</button>
      </div>
    </div>
  </div>
  <div class="event-card">
    <div class="card-header purple-gradient">
      <h3>Tech Conference 2024</h3>
      <span class="badge upcoming">upcoming</span>
    </div>
    <div class="card-body">
      <p><i class="bi bi-calendar"></i> 15/03/2024 at 09:00</p>
      <p><i class="bi bi-geo-alt"></i> Convention Center, Tech City</p>
      <p><i class="bi bi-people"></i> 245/500 &nbsp;&nbsp; <i class="bi bi-clock"></i> 8h</p>
      <p><i class="bi bi-currency-dollar"></i> 199.99</p>
      <p class="description">Annual tech conference with sessions on AI, cloud computing, and more.</p>
      <div class="btn-group">
        <button class="btn view"><i class="bi bi-eye"></i> View Details</button>
        <button class="btn register"><i class="bi bi-box-arrow-in-right"></i> Register</button>
      </div>
    </div>
  </div>
</section>


@endsection

@section('extra-js')
  <script src="{{ asset('assets/js/events.js') }}"></script>
@endsection