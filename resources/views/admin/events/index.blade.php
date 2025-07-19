@extends('layouts.app')

@section('title', 'Manage Events')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets/css/admin-events.css') }}">
@endsection

@section('content')
<div class="admin-events-container">
  <h2>All Events</h2>

  {{-- Success Message --}}
  @if(session('success'))
    <div class="alert success">{{ session('success') }}</div>
  @endif

  {{-- Add Event Button --}}
  <a href="{{ route('admin.events.create') }}" class="btn btn-primary">+ Add New Event</a>

  {{-- Events Table --}}
  <table class="events-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Title</th>
        <th>Location</th>
        <th>Date</th>
        <th>Thumbnail</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($events as $event)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $event->title }}</td>
          <td>{{ $event->location }}</td>
          <td>{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
          <td>
            @if($event->thumbnail)
              <img src="{{ asset('storage/events/' . $event->thumbnail) }}" alt="Thumbnail" height="50">
            @else
              <span class="text-muted">No Image</span>
            @endif
          </td>
          <td>
            <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to delete this event?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6">No events found.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
