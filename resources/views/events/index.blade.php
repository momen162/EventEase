@extends('layouts.app')
@section('title','Events')

@section('extra-css')
  {{-- Keep your custom CSS --}}
  <link rel="stylesheet" href="{{ asset('assets/css/events.css') }}">
  {{-- Icons --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  {{-- Tailwind for modern styling --}}
  <script src="https://cdn.tailwindcss.com"></script>
@endsection

@section('content')
<section class="py-10">
  <div class="mx-auto max-w-6xl px-3">
    {{-- Hero/Heading --}}
    <div class="mb-8 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 p-8 text-white shadow-lg">
      <h1 class="text-2xl md:text-3xl font-semibold">Discover Events</h1>
      <p class="mt-1 text-indigo-100">Grow your network and build your skills with our curated experiences.</p>
    </div>

    {{-- Cards Grid --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      @forelse ($events as $e)
        <div class="group overflow-hidden rounded-2xl bg-white shadow hover:shadow-xl transition-shadow">
          {{-- Header --}}
          <div class="flex items-center justify-between bg-gradient-to-r from-indigo-500/20 to-purple-500/20 px-5 py-4">
            <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $e->title }}</h3>
            <span class="rounded-full bg-yellow-400/90 px-3 py-1 text-xs font-semibold text-gray-900 shadow-sm">
              Upcoming
            </span>
          </div>

          {{-- Body --}}
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

            <p class="text-sm text-gray-600">
              {{ \Illuminate\Support\Str::limit(strip_tags($e->description), 120) }}
            </p>

            <div class="mt-4 flex items-center justify-between gap-3">
              <a class="flex-1 inline-flex items-center justify-center rounded-xl border border-indigo-300 px-4 py-2 text-indigo-700 font-medium hover:bg-indigo-50"
                 href="{{ route('events.show', $e) }}">
                <i class="bi bi-eye mr-2"></i> Details
              </a>

              {{-- Buy → POST to tickets.start (qty=1) --}}
              <form method="POST" action="{{ route('tickets.start', $e) }}">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-green-600 px-4 py-2 text-white font-semibold shadow hover:bg-green-700">
                  <i class="bi bi-box-arrow-in-right mr-2"></i> Buy
                </button>
              </form>
            </div>
          </div>
        </div>
      @empty
        <p class="text-gray-600">No events yet.</p>
      @endforelse
    </div>

    <div class="mt-8">{{ $events->links() }}</div>
  </div>
</section>
@endsection

@section('extra-js')
  <script src="{{ asset('assets/js/events.js') }}"></script>
@endsection
