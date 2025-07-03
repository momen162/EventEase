<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EventHub Dashboard</title>
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
  <header>
    <div class="logo">📅 <span>EventHub</span></div>
    <nav>
      <a class="active" href="#">Dashboard</a>
      <a href="#">Events</a>
      <a href="#">Analytics</a>
    </nav>
    <div class="login-section">
      <span>👤 Guest</span>
      <button>Login</button>
    </div>
  </header>

  <main>
    <section class="stats">
      <div class="card">
        <div class="icon">📅</div>
        <h2>3</h2>
        <p>Total Events</p>
      </div>
      <div class="card">
        <div class="icon">👥</div>
        <h2>3</h2>
        <p>Total Registrations</p>
      </div>
      <div class="card">
        <div class="icon">💲</div>
        <h2>$53197.13</h2>
        <p>Total Revenue</p>
      </div>
      <div class="card">
        <div class="icon">📈</div>
        <h2>33.3%</h2>
        <p>Attendance Rate</p>
      </div>
    </section>

    <section class="recent-events">
      <h2>Recent Events</h2>

      <div class="event">
        <div class="date">
          <span>Mar</span>
          <strong>15</strong>
        </div>
        <div class="info">
          <h3>Tech Conference 2024</h3>
          <p>Convention Center, Tech City • 245 registered</p>
        </div>
      </div>

      <div class="event">
        <div class="date">
          <span>Feb</span>
          <strong>28</strong>
        </div>
        <div class="info">
          <h3>JavaScript Workshop</h3>
          <p>Learning Hub, Downtown • 43 registered</p>
        </div>
      </div>
    </section>
  </main>
</body>
</html>
