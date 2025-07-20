@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="admin-login-container">
  <h2>Admin Login</h2>

  @if($errors->any())
    <div class="errors">
      @foreach($errors->all() as $error)
        <p class="error">{{ $error }}</p>
      @endforeach
    </div>
  @endif

  <form method="POST" action="{{ route('admin.login.submit') }}">
    @csrf
    <label for="email">Email:</label>
    <input type="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
  </form>
</div>
@endsection
