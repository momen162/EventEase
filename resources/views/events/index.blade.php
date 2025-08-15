@extends('layouts.app')
@section('title','Events')

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/events.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection

@section('content')
<section class="hero-banner">
  <div class="hero-container">
    <div class="hero-slider">
      <img src="{{ asset('assets/images/banner1.jpg') }}" class="slide active" alt="">
      <img src="{{ asset('assets/images/banner2.jpg') }}" class="slide" alt="">
      <img src="{{ asset('assets/images/banner3.jpg') }}" class="slide" alt="">
    </div>
    <div class="hero-text">
      <h1>Grow Your Network & Build Your Skills with Our Events!</h1>
    </div>
  </div>
</section>

<section class="event-cards">
  @forelse ($events as $e)
    <div class="event-card" data-status="upcoming">
      <div class="card-header purple-gradient">
        <h3>{{ $e->title }}</h3>
        <span class="badge upcoming">upcoming</span>
      </div>
      <div class="card-body">
        <p><i class="bi bi-calendar"></i> {{ optional($e->starts_at)->format('d/m/Y H:i') }}</p>
        <p><i class="bi bi-geo-alt"></i> {{ $e->venue ?? $e->location }}</p>
        <p><i class="bi bi-currency-dollar"></i> {{ number_format($e->price,2) }}</p>
        <p class="description">{{ \Illuminate\Support\Str::limit(strip_tags($e->description), 120) }}</p>
        <div class="btn-group">
          <a class="btn view" href="{{ route('events.show', $e) }}"><i class="bi bi-eye"></i> Details</a>

          {{-- direct buy (posts to tickets.start) --}}
          <form method="POST" action="{{ route('tickets.start', $e) }}" style="display:inline-block">
            @csrf
            <input type="hidden" name="quantity" value="1">
            <button class="btn register" type="submit"><i class="bi bi-box-arrow-in-right"></i> Buy</button>
          </form>
        </div>
      </div>
    </div>
  @empty
    <p>No events yet.</p>
  @endforelse

  <div style="margin-top:16px">{{ $events->links() }}</div>
</section>
@endsection

@section('extra-js')
  <script src="{{ asset('assets/js/events.js') }}"></script>
@endsection
