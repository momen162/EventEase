@extends('layouts.app')

@section('title', 'Edit Profile')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endsection

@section('content')
<section class="edit-profile-wrapper">
  <h2>Edit Your Profile</h2>

 <form method="POST" action="{{ route('profile.update') }}" class="edit-form" enctype="multipart/form-data">
  @csrf

  <label>Name</label>
  <input type="text" name="name" value="{{ old('name', $user->name) }}" required>

  <label>Email</label>
  <input type="email" name="email" value="{{ old('email', $user->email) }}" required>

  <label>Phone</label>
  <input type="text" name="phone" value="{{ old('phone', $user->phone) }}">

  <label>New Password</label>
  <input type="password" name="password" placeholder="Leave blank to keep current">

  <label>Confirm Password</label>
  <input type="password" name="password_confirmation" placeholder="Confirm password">

  <label>Profile Picture</label>
  <input type="file" name="profile_picture" accept="image/*">

  @if($user->profile_picture)
    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" style="height: 60px;">
  @endif

  <button type="submit">Update</button>
</form>

</section>
@endsection
