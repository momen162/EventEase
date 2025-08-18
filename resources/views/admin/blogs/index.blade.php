@extends('admin.layout')
@section('title','Blogs')
@section('content')
<h1>Blogs</h1>
<p><a class="btn btn-primary" href="{{ route('admin.blogs.create') }}">+ New Blog</a></p>

@if ($blogs->isEmpty())
  <div class="empty">No blogs yet.</div>
@else
<div class="table-wrap">
  <table class="table">
    <thead>
      <tr><th>ID</th><th>Title</th><th>Author</th><th>Image</th><th>Created</th><th>Actions</th></tr>
    </thead>
    <tbody>
      @foreach ($blogs as $b)
        <tr>
          <td>{{ $b->id }}</td>
          <td>{{ $b->title }}</td>
          <td>{{ $b->author }}</td>
          <td>
            @if($b->image)
              <img src="{{ asset('storage/'.$b->image) }}" alt="" style="height:40px">
            @endif
          </td>
          <td>{{ $b->created_at }}</td>
          <td style="white-space:nowrap">
            <a class="btn" href="{{ route('admin.blogs.edit', $b) }}">Edit</a>
            <form action="{{ route('admin.blogs.destroy', $b) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this blog?')">
              @csrf @method('DELETE')
              <button class="btn btn-ghost" type="submit">Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endif
@endsection
