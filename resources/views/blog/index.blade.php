@extends('layouts.app')

@section('title', 'Blog')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
@endsection

@section('content')
<div class="blog-page">

  {{-- Wrap content and aside together --}}
  <div class="main-content-with-sidebar">

    {{-- Main blog content --}}
    <div class="main-content">
      <div class="news-banner">
        <h2>Discover Our Latest News</h2>
      </div>

      @if ($blogs->count() > 0)
        {{-- Feature Post --}}
        <div class="feature-post">
          <img src="{{ asset('assets/images/' . $blogs[0]->image) }}" alt="Feature Image">
          <div class="blog-content">
            <h3>{{ $blogs[0]->title }}</h3>
            <p class="blog-snippet">{{ $blogs[0]->short_description }}</p>
            <a href="{{ route('blog.show', $blogs[0]->id) }}" class="read-more-btn">Read More →</a>
          </div>
        </div>
      @endif

      <h2>Our Recent Articles</h2>
      <div class="blog-list">
        @foreach ($blogs->skip(1) as $blog)
          <div class="blog-card">
            <img src="{{ asset('assets/images/' . $blog->image) }}" alt="Blog Image">
            <div class="blog-content">
              <h3>{{ $blog->title }}</h3>
              <p class="blog-snippet">{{ $blog->short_description }}</p>
              <a href="{{ route('blog.show', $blog->id) }}" class="read-more-btn">Read More</a>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    {{-- Aside with Calendar and Clock --}}
    <aside class="sidebar">
      <div class="clock-section">
        <h3>Current Time</h3>
        <div id="digitalClock" class="digital-clock"></div>
      </div>

      <div class="calendar-section">
        <h3>Calendar</h3>
        <div id="calendar"></div>
      </div>
    </aside>

  </div> {{-- end .main-content-with-sidebar --}}
</div>
@endsection

@section('extra-js')
<script>
  // 📅 Generate Calendar
  function generateCalendar() {
    const calendar = document.getElementById('calendar');
    const now = new Date();
    const year = now.getFullYear();
    const month = now.getMonth();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const startDay = new Date(year, month, 1).getDay();
    const today = now.getDate();
    const monthNames = [
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    ];

    let html = `<h4>${monthNames[month]} ${year}</h4>`;
    html += '<table><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr><tr>';

    for (let i = 0; i < startDay; i++) {
      html += '<td></td>';
    }

    for (let day = 1; day <= daysInMonth; day++) {
      if ((startDay + day - 1) % 7 === 0) html += '</tr><tr>';
      const isToday = day === today ? ' class="today"' : '';
      html += `<td${isToday}>${day}</td>`;
    }

    html += '</tr></table>';
    calendar.innerHTML = html;
  }

  // ⏰ Live Digital Clock
  function updateClock() {
    const now = new Date();
    const time = now.toLocaleTimeString();
    document.getElementById('digitalClock').innerText = time;
  }

  document.addEventListener('DOMContentLoaded', function() {
    generateCalendar();
    updateClock();
    setInterval(updateClock, 1000);
  });
</script>
@endsection
