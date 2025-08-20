@extends('layouts.app')

@section('title', 'Home')

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/event-slider.css') }}">
@endsection

@section('content')
  <!-- 🔹 Hero Section -->
  <section class="hero-section" aria-label="Hero">
    <div class="hero-flex-container">
      {{-- Banner Slider --}}
      <div class="slider-container" aria-roledescription="carousel" aria-label="Promotional banners">
        <div class="slider" id="slider">
          <a href="https://eventease.laravel.cloud/event1" class="slide-link active" target="_blank" rel="noopener noreferrer" aria-label="Open Event 1 in new tab">
            <img src="{{ asset('assets/images/banner1.png') }}" class="slide-img" alt="Event 1 banner" loading="lazy" decoding="async" />
          </a>
          <a href="https://eventease.laravel.cloud/event2" class="slide-link" target="_blank" rel="noopener noreferrer" aria-label="Open Event 2 in new tab">
            <img src="{{ asset('assets/images/banner2.png') }}" class="slide-img" alt="Event 2 banner" loading="lazy" decoding="async" />
          </a>
          <a href="https://eventease.laravel.cloud/event3" class="slide-link" target="_blank" rel="noopener noreferrer" aria-label="Open Event 3 in new tab">
            <img src="{{ asset('assets/images/banner3.png') }}" class="slide-img" alt="Event 3 banner" loading="lazy" decoding="async" />
          </a>
        </div>

        <button class="slider-btn prev" id="prevBtn" type="button" aria-label="Previous slide" aria-controls="slider">←</button>
        <button class="slider-btn next" id="nextBtn" type="button" aria-label="Next slide" aria-controls="slider">→</button>

        <div class="slider-indicators" id="sliderDots" role="tablist" aria-label="Slide indicators"></div>
      </div>

      {{-- Embedded YouTube Video --}}
      <div class="video-wrapper">
        <iframe
          src="https://www.youtube.com/embed/VDpwq_77gvM"
          title="EventEase Promo"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          referrerpolicy="strict-origin-when-cross-origin"
          allowfullscreen
          loading="lazy"></iframe>
      </div>
    </div>
  </section>

  <!-- 🔹 Event Type Infinite Slider -->
  <section class="event-type-slider" aria-label="Browse event types">
    <div class="event-type-wrapper">
      <button class="arrow-btn left" id="eventTypePrev" type="button" aria-label="Scroll left">←</button>

      <div class="event-type-scroll" id="eventTypeScroll" tabindex="0" role="region" aria-label="Event type list">
        <div class="event-type-track" id="eventTypeTrack">
          <div class="event-type-item">
            <img src="{{ asset('assets/icons/event/competitions.png') }}" alt="Competitions" loading="lazy" decoding="async">
            <p>Competitions</p>
          </div>
          <div class="event-type-item">
            <img src="{{ asset('assets/icons/event/fashion.png') }}" alt="Fashion Shows" loading="lazy" decoding="async">
            <p>Fashion<br>Shows</p>
          </div>
          <div class="event-type-item">
            <img src="{{ asset('assets/icons/event/conference.png') }}" alt="Conferences" loading="lazy" decoding="async">
            <p>Conferences</p>
          </div>
          <div class="event-type-item">
            <img src="{{ asset('assets/icons/event/seminar.png') }}" alt="Seminars" loading="lazy" decoding="async">
            <p>Seminars</p>
          </div>
          <div class="event-type-item">
            <img src="{{ asset('assets/icons/event/reunion.png') }}" alt="Reunions" loading="lazy" decoding="async">
            <p>Reunions</p>
          </div>
          <div class="event-type-item">
            <img src="{{ asset('assets/icons/event/exhibition.png') }}" alt="Exhibitions" loading="lazy" decoding="async">
            <p>Exhibitions</p>
          </div>
          <div class="event-type-item">
            <img src="{{ asset('assets/icons/event/launch.png') }}" alt="Launching" loading="lazy" decoding="async">
            <p>Launching</p>
          </div>
          <div class="event-type-item">
            <img src="{{ asset('assets/icons/event/standup.png') }}" alt="Stand-up" loading="lazy" decoding="async">
            <p>Stand-up</p>
          </div>
          <div class="event-type-item">
            <img src="{{ asset('assets/icons/event/drama.png') }}" alt="Drama" loading="lazy" decoding="async">
            <p>Drama</p>
          </div>
          <div class="event-type-item">
            <img src="{{ asset('assets/icons/event/party.png') }}" alt="Party" loading="lazy" decoding="async">
            <p>Party</p>
          </div>
          <div class="event-type-item">
            <img src="{{ asset('assets/icons/event/concert.png') }}" alt="Concerts" loading="lazy" decoding="async">
            <p>Concerts</p>
          </div>
          <div class="event-type-item">
            <img src="{{ asset('assets/icons/event/festival.png') }}" alt="Festival" loading="lazy" decoding="async">
            <p>Festival</p>
          </div>
          <div class="event-type-item">
            <img src="{{ asset('assets/icons/event/hackathon.png') }}" alt="Hackathon" loading="lazy" decoding="async">
            <p>Hackathon</p>
          </div>
          <div class="event-type-item">
            <img src="{{ asset('assets/icons/event/sports.png') }}" alt="Sports" loading="lazy" decoding="async">
            <p>Sports</p>
          </div>
          <div class="event-type-item">
            <img src="{{ asset('assets/icons/event/workshop.png') }}" alt="Workshop" loading="lazy" decoding="async">
            <p>Workshop</p>
          </div>
        </div>
      </div>

      <button class="arrow-btn right" id="eventTypeNext" type="button" aria-label="Scroll right">→</button>
    </div>
  </section>

  <!-- 🔹 Upcoming Events -->
  <section class="upcoming-events" aria-labelledby="upcoming-events-heading">
    <h2 id="upcoming-events-heading">Explore Upcoming Events</h2>
    <div class="event-cards">
      <a href="https://eventease.com/tech-summit" class="event-card" target="_blank" rel="noopener noreferrer">
        <img src="{{ asset('assets/images/card1.png') }}" alt="Tech Summit 2025" loading="lazy" decoding="async">
        <div class="card-info">
          <h3>Tech Summit 2025</h3>
          <p><time datetime="2025-08-21">August 21</time> • Convention Center</p>
        </div>
      </a>

      <a href="http://127.0.0.1:8000/events/2" class="event-card" target="_blank" rel="noopener noreferrer">
        <img src="{{ asset('assets/images/card2.png') }}" alt="Music Fest Live" loading="lazy" decoding="async">
        <div class="card-info">
          <h3>Music Fest Live</h3>
          <p><time datetime="2025-09-09">September 9</time> • DIU Auditorium</p>
        </div>
      </a>

      <a href="https://eventease.com/startup-fair" class="event-card" target="_blank" rel="noopener noreferrer">
        <img src="{{ asset('assets/images/card3.png') }}" alt="Startup Fair" loading="lazy" decoding="async">
        <div class="card-info">
          <h3>Startup Fair</h3>
          <p><time datetime="2025-09-25">September 25</time> • Knowledge</p>
        </div>
      </a>
    </div>
  </section>

  <!-- 🔹 Our Offerings -->
  <section class="our-offerings" aria-labelledby="our-offerings-heading">
    <h2 id="our-offerings-heading">Our Offerings</h2>
    <p class="offer-subtitle">Explore the key features that make <b>EventEase</b> the perfect choice for event organizers!</p>

    <div class="offer-grid">
      <div class="offer-item">
        <img src="{{ asset('assets/icons/icon1.png') }}" alt="Easy Ticket Purchase" loading="lazy" decoding="async" />
        <h3>Easy Ticket Purchase</h3>
        <p>Browse and purchase tickets for a variety of events, from concerts to conferences, all from your device with ease and convenience.</p>
      </div>

      <div class="offer-item">
        <img src="{{ asset('assets/icons/icon2.png') }}" alt="Instant Ticket Delivery" loading="lazy" decoding="async" />
        <h3>Instant Ticket Delivery</h3>
        <p>Receive your tickets immediately upon purchase via email. If preferred, users can also opt to receive their tickets on WhatsApp.</p>
      </div>

      <div class="offer-item">
        <img src="{{ asset('assets/icons/icon3.png') }}" alt="Multiple Payment Methods" loading="lazy" decoding="async" />
        <h3>Multiple Payment Methods</h3>
        <p>Enjoy flexible payment options with bKash, Nagad, Upay, Visa, Mastercard, and more, ensuring secure and smooth transactions.</p>
      </div>

      <div class="offer-item">
        <img src="{{ asset('assets/icons/icon4.png') }}" alt="Tickipass Feature" loading="lazy" decoding="async" />
        <h3>Tickipass Feature</h3>
        <p>Access purchased tickets instantly with Tickipass, displaying QR codes from your device, eliminating the need for printed e-ticket PDFs.</p>
      </div>

      <div class="offer-item">
        <img src="{{ asset('assets/icons/icon5.png') }}" alt="Comprehensive Dashboard" loading="lazy" decoding="async" />
        <h3>Comprehensive Dashboard</h3>
        <p>Access real-time sales reports and attendance data through our user-friendly dashboard, providing valuable insights at your fingertips.</p>
      </div>

      <div class="offer-item">
        <img src="{{ asset('assets/icons/icon6.png') }}" alt="Smooth Scanning" loading="lazy" decoding="async" />
        <h3>Smooth Scanning</h3>
        <p>Streamline the entry process with our efficient ticket scanning system, ensuring a hassle-free experience for attendees and organizers.</p>
      </div>
    </div>
  </section>

  <!-- 🔹 FAQ Section -->
  <section class="faq-section" aria-labelledby="faq-heading">
    <h2 id="faq-heading">Frequently Asked Questions</h2>
    <div class="faq-container" role="list">
      <div class="faq-item" role="listitem">
        <button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-a1">
          How do I buy a ticket? <span class="icon" aria-hidden="true">+</span>
        </button>
        <div class="faq-answer" id="faq-a1" hidden>
          <p>You can book tickets through the Events section after logging in.</p>
        </div>
      </div>

      <div class="faq-item" role="listitem">
        <button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-a2">
          Where are the events hosted? <span class="icon" aria-hidden="true">+</span>
        </button>
        <div class="faq-answer" id="faq-a2" hidden>
          <p>We host both online and offline events. Locations are shown on each event card.</p>
        </div>
      </div>

      <div class="faq-item" role="listitem">
        <button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-a3">
          Can I refund or reschedule? <span class="icon" aria-hidden="true">+</span>
        </button>
        <div class="faq-answer" id="faq-a3" hidden>
          <p>Yes, depending on the event organizer's policy. See event terms for details.</p>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('extra-js')
  <script src="{{ asset('assets/js/home.js') }}"></script>
  <script src="{{ asset('assets/js/event-slider.js') }}"></script>
@endsection
