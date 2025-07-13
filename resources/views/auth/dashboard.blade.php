@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
  <section class="dashboard-wrapper">
    <h2>Welcome, {{ $user->name }}</h2>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Phone:</strong> {{ $user->phone ?? 'Not set' }}</p>
    <a href="{{ route('profile.edit') }}" class="btn-edit">Edit Profile</a>
  </section>
@endsection
