@extends('layouts.app')

@section('title', 'Events')

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/events.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection

@section('content')




<!-- Filter/Search -->

<section class="filter-search-wrapper">
  <div class="filter-options">
    <label><input type="radio" name="eventStatus" value="all" checked> All</label>
    <label><input type="radio" name="eventStatus" value="ongoing"> Live</label>
    <label><input type="radio" name="eventStatus" value="upcoming"> Upcoming</label>
  </div>
  
 <div class="search-box">
  <button id="searchBtn"><i class="bi bi-sliders"></i></button>
  <input type="text" id="searchInput" placeholder="Search Events..">
  <i class="bi bi-search search-icon" id="triggerSearch" style="cursor:pointer;"></i>
</div>

</section>

<!-- Event Cards -->
<section class="event-cards">
  <div class="event-card" data-status="ongoing">
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
  <div class="event-card" data-status="ongoing">
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

  <div class="event-card" data-status="completed">
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

  <div class="event-card" data-status="upcoming">
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

  <div class="event-card" data-status="upcoming">
    <div class="card-header purple-gradient">
      <h3>Python Bootcamp</h3>
      <span class="badge upcoming">upcoming</span>
    </div>
    <div class="card-body">
      <p><i class="bi bi-calendar"></i> 20/03/2024 at 10:00</p>
      <p><i class="bi bi-geo-alt"></i> Innovation Lab, New Town</p>
      <p><i class="bi bi-people"></i> 90/100 &nbsp;&nbsp; <i class="bi bi-clock"></i> 6h</p>
      <p><i class="bi bi-currency-dollar"></i> 149.99</p>
      <p class="description">Bootcamp to master Python fundamentals and data science tools.</p>
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
