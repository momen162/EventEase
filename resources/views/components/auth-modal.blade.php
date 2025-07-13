<div id="authModal" class="modal-overlay" style="display: none;">
  <div class="modal-content">
    <span class="close-modal" onclick="closeAuthModal()">&times;</span>

    <div class="auth-tabs">
      <button class="tab-btn active" onclick="switchAuthTab('login')">Login</button>
      <button class="tab-btn" onclick="switchAuthTab('register')">Register</button>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login.custom') }}" class="auth-form" id="loginForm">
      @csrf
      <label>Email</label>
      <input type="email" name="email" placeholder="Enter email" required>

      <label>Password</label>
      <input type="password" name="password" placeholder="Enter password" required>

      <button type="submit">Login</button>

      <p class="auth-or">OR</p>

      <div class="social-login">
        <a href="{{ url('/auth/google') }}" class="google-btn">Continue with Google</a>
        <a href="{{ url('/auth/facebook') }}" class="facebook-btn">Continue with Facebook</a>
      </div>
    </form>

    <!-- Register Form -->
    <form method="POST" action="{{ route('register.custom') }}" class="auth-form" id="registerForm">
      @csrf
      <label>Full Name</label>
      <input type="text" name="name" placeholder="Enter full name" required>

      <label>Email</label>
      <input type="email" name="email" placeholder="Enter email" required>

      <label>Password</label>
      <input type="password" name="password" placeholder="Enter password" required>

      <label>Confirm Password</label>
      <input type="password" name="password_confirmation" placeholder="Confirm password" required>

      <button type="submit">Register</button>

      <p class="auth-or">OR</p>

      <div class="social-login">
        <a href="{{ url('/auth/google') }}" class="google-btn">Continue with Google</a>
        <a href="{{ url('/auth/facebook') }}" class="facebook-btn">Continue with Facebook</a>
      </div>
    </form>
  </div>
</div>
