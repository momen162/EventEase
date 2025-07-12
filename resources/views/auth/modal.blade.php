<!-- Modal Container -->
<div id="authModal" class="auth-modal-overlay">
  <div class="auth-modal">
    <span class="auth-close" onclick="closeAuthModal()">&times;</span>

    <!-- Tabs -->
    <div class="auth-tabs">
      <button id="loginTab" class="active" onclick="switchAuthTab('login')">Login</button>
      <button id="registerTab" onclick="switchAuthTab('register')">Register</button>
    </div>

    <!-- Login Form -->
    <div id="loginForm" class="auth-form active">
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required minlength="6">
        <button type="submit">Login</button>
      </form>

      <div class="auth-divider">OR</div>
      <div class="social-buttons">
        <a href="{{ url('/auth/google') }}" class="google-btn">Login with Google</a>
        <a href="{{ url('/auth/facebook') }}" class="facebook-btn">Login with Facebook</a>
      </div>
    </div>

    <!-- Register Form -->
    <div id="registerForm" class="auth-form">
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="text" name="name" placeholder="Name" required minlength="3">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required minlength="6">
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        <button type="submit">Create Account</button>
      </form>

      <div class="auth-divider">OR</div>
      <div class="social-buttons">
        <a href="{{ url('/auth/google') }}" class="google-btn">Signup with Google</a>
        <a href="{{ url('/auth/facebook') }}" class="facebook-btn">Signup with Facebook</a>
      </div>
    </div>
  </div>
</div>
