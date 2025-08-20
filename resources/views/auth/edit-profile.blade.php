@extends('layouts.app')

@section('title', 'Edit Profile')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endsection

@section('content')
<section class="edit-profile-wrapper">
  <div class="card">
    <header class="card__header">
      <h2>Edit Your Profile</h2>
      <p class="card__sub">Update your personal info and security.</p>
    </header>

    <form method="POST" action="{{ route('profile.update') }}" class="edit-form" enctype="multipart/form-data">
      @csrf

      <div class="grid">
        <div class="field">
          <label>Name</label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name">
        </div>

        <div class="field">
          <label>Email</label>
          <input type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
        </div>
      </div>

      <div class="field">
        <label>Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" autocomplete="tel">
      </div>

      <div class="grid">
        <div class="field">
          <label>New Password</label>
          <input type="password" name="password" placeholder="Leave blank to keep current" autocomplete="new-password">
        </div>

        <div class="field">
          <label>Confirm Password</label>
          <input type="password" name="password_confirmation" placeholder="Confirm password" autocomplete="new-password">
        </div>
      </div>

      <div class="field">
        <label>Profile Picture</label>
        <div class="file-row">
          <input type="file" name="profile_picture" accept="image/*">
          @if($user->profile_picture)
            <img class="avatar-preview" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture">
          @endif
        </div>
        <small class="hint">PNG/JPG up to 2MB is recommended.</small>
      </div>

      <div class="actions">
        <button type="submit" class="btn-primary">Update</button>
      </div>
    </form>
  </div>
</section>
@endsection
