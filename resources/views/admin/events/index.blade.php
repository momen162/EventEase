@extends('admin.layout')
@section('title','Events')
@section('content')
<div class="grid">
  <div class="col-12">
    <div class="card">
      <div style="display:flex; align-items:center; justify-content:space-between; gap:12px">
        <div>
          <h2>Events</h2>
          <p class="help">Create, edit, and manage events.</p>
        </div>
        <a class="btn btn-primary" href="{{ route('admin.events.create') }}">+ New Event</a>
      </div>

      @if($events->isEmpty())
        <div class="empty">No events yet. Click <strong>+ New Event</strong> to create one.</div>
      @else
        <div class="table-wrap">
          <table>
            <thead>
              <tr><th>ID</th><th>Title</th><th>When</th><th>Location</th><th>Cap.</th><th>Actions</th></tr>
            </thead>
            <tbody>
              @foreach($events as $e)
              <tr>
                <td>{{ $e->id }}</td>
                <td>{{ $e->title }}</td>
                <td>{{ $e->starts_at }} — {{ $e->ends_at }}</td>
                <td>{{ $e->location }}</td>
                <td>{{ $e->capacity }}</td>
                <td>
                  <a class="btn btn-sm" href="{{ route('admin.events.edit',$e) }}">Edit</a>
                  <form style="display:inline" method="POST" action="{{ route('admin.events.destroy',$e) }}" onsubmit="return confirm('Delete event?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif

      <div style="margin-top:14px">
        <a href="{{ route('admin.index') }}" class="btn btn-ghost">Back</a>
      </div>
    </div>
  </div>
</div>
@endsection
