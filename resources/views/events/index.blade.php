@extends('layouts.app')
@section('title','Events')
@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets/css/events.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script src="https://cdn.tailwindcss.com"></script>
@endsection
@section('content')
<section class="hero-banner">
  <div class="hero-container">
    <div class="hero-slider">
      <img src="{{ asset('assets/images/banner1.jpg') }}" class="slide active" alt="">
      <img src="{{ asset('assets/images/banner2.jpg') }}" class="slide" alt="">
      <img src="{{ asset('assets/images/banner3.jpg') }}" class="slide" alt="">
    </div>
  </div>
</section>
<section class="py-10">
  <div class="mx-auto max-w-6xl px-3">
    <div class="mb-8 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 p-8 text-white shadow-lg">
      <h1 class="text-2xl md:text-3xl font-semibold">Discover Events</h1>
      <p class="mt-1 text-indigo-100">Grow your network and build your skills with our curated experiences.</p>
    </div>
    <div class="event-cards grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      @forelse ($events as $e)
        <div class="group overflow-hidden rounded-2xl bg-white shadow hover:shadow-xl transition-shadow">
          <div class="flex items-center justify-between bg-gradient-to-r from-indigo-500/20 to-purple-500/20 px-5 py-4">
            <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $e->title }}</h3>
            <span class="rounded-full bg-yellow-400/90 px-3 py-1 text-xs font-semibold text-gray-900 shadow-sm">Upcoming</span>
          </div>
          <div class="p-5 space-y-3">
            <p class="flex items-center gap-2 text-gray-700">
              <i class="bi bi-calendar text-indigo-600"></i>
              <span>{{ optional($e->starts_at)->format('d/m/Y H:i') }}</span>
            </p>
            <p class="flex items-center gap-2 text-gray-700">
              <i class="bi bi-geo-alt text-indigo-600"></i>
              <span>{{ $e->venue ?? $e->location }}</span>
            </p>
            <p class="flex items-center gap-2 text-gray-700">
              <i class="bi bi-currency-dollar text-indigo-600"></i>
              <span class="font-medium">{{ number_format($e->price,2) }}</span>
            </p>
            <p class="description">{{ \Illuminate\Support\Str::limit(strip_tags($e->description), 120) }}</p>
            <div class="btn-group">
              <a class="btn view" href="{{ route('events.show', $e) }}">
                <i class="bi bi-eye"></i> Details
              </a>
              <form method="POST" action="{{ route('tickets.start', $e) }}">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-green-600 px-4 py-2 text-white font-semibold shadow hover:bg-green-700">
                  <i class="bi bi-box-arrow-in-right mr-2"></i> Buy
                </button>
              </form>
            </div>
          </div>
        </div>
      @empty
        <p>No events yet.</p>
      @endforelse
    </div>
    <div class="mt-8">{{ $events->links() }}</div>
  </div>
</section>
@endsection
