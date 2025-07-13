@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section class="dashboard">
  <h2>Hello, {{ $user->name }}</h2>
  <p><strong>Email:</strong> {{ $user->email }}</p>
  <a href="{{ route('profile.edit') }}" class="btn">Edit Profile</a>
</section>
@endsection
