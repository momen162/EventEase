@extends('layouts.app')

@section('title', 'Events')

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/events.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection

@section('content')

<!-- Banner Section -->

<section class="hero-banner">
  <div class="hero-container">
    
    <!-- Left: Image Slider -->
    <div class="hero-slider">
      <img src="{{ asset('assets/images/banner1.jpg') }}" class="slide active" alt="Event Banner 1">
      <img src="{{ asset('assets/images/banner2.jpg') }}" class="slide" alt="Event Banner 2">
      <img src="{{ asset('assets/images/banner3.jpg') }}" class="slide" alt="Event Banner 3">
    </div>

    <!-- Right: Text Content -->
    <div class="hero-text">
      <h1>Grow Your Network & Build Your Skills with Our<br> Events!</h1>
     
    </div>

  </div>
</section>


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
  @forelse($events as $event)
    <div class="event-card" data-status="upcoming">
      <div class="card-header purple-gradient">
        <h3>{{ $event->title }}</h3>
        <span class="badge upcoming">{{ now()->lt($event->starts_at) ? 'upcoming' : 'ongoing' }}</span>
      </div>
      <div class="card-body">
        <p><i class="bi bi-calendar"></i>
           {{ optional($event->starts_at)->format('d/m/Y \a\t H:i') }}
        </p>
        <p><i class="bi bi-geo-alt"></i> {{ $event->location }}</p>
        <p><i class="bi bi-people"></i> {{ $event->capacity ?? '—' }}</p>
        <p><i class="bi bi-currency-dollar"></i> {{ number_format($event->price,2) }}</p>
        @if($event->description)
          <p class="description">{{ \Illuminate\Support\Str::limit(strip_tags($event->description), 140) }}</p>
        @endif

        <div class="btn-group">
          <a class="btn view" href="{{ route('events.show', $event) }}"><i class="bi bi-eye"></i> View Details</a>
          <a class="btn register" href="{{ route('events.buy', $event) }}"><i class="bi bi-box-arrow-in-right"></i> Buy</a>
        </div>
      </div>
    </div>
  @empty
    <p>No events yet.</p>
  @endforelse

  <div style="margin-top:16px;">
    {{ $events->links() }}
  </div>
</section>

@endsection

@section('extra-js')
  <script src="{{ asset('assets/js/events.js') }}"></script>
@endsection
