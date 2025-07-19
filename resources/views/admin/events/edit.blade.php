@extends('layouts.app')

@section('title', 'Edit Event')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets/css/admin-events.css') }}">
@endsection

@section('content')
<div class="admin-events-container">
  <h2>Edit Event: {{ $event->title }}</h2>

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
  <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.events._form', ['event' => $event])
    <button type="submit" class="btn btn-primary">Update Event</button>
  </form>
</div>
@endsection
