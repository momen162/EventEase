@extends('layouts.app')

@section('title', 'Edit Profile')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets/css/edit-profile.css') }}">
@endsection

@section('content')
<section class="edit-profile-wrapper">
  <h2>Edit Your Profile</h2>

<form method="POST" action="{{ route('profile.update') }}" class="edit-form">
  @csrf

  <label>Name</label>
  <input type="text" name="name" value="{{ old('name', $user->name) }}" required>

  <label>Email</label>
  <input type="email" name="email" value="{{ old('email', $user->email) }}" required>

  <label>Phone</label>
  <input type="text" name="phone" value="{{ old('phone', $user->phone) }}">

  <label>New Password <small>(leave blank to keep current)</small></label>
  <input type="password" name="password" placeholder="New password (optional)">

  <label>Confirm Password</label>
  <input type="password" name="password_confirmation" placeholder="Confirm password">

  <button type="submit">Update Profile</button>
</form>

</section>
@endsection
