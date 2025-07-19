@extends('layouts.app')

@section('title', 'Create Event')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets/css/admin-events.css') }}">
@endsection

@section('content')
<div class="admin-events-container">
  <h2>Create New Event</h2>

  {{-- Validation Errors --}}
  @if ($errors->any())
    <div class="alert error">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Event Form --}}
  <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.events._form', ['event' => null])
    <button type="submit" class="btn btn-success">Create Event</button>
  </form>
</div>
@endsection
