@extends('admin.layout')
@section('title','Edit Blog')
@section('content')
<h1>Edit Blog</h1>
<form method="POST" action="{{ route('admin.blogs.update', $blog) }}" enctype="multipart/form-data" class="form">
  @csrf @method('PUT')
  <label>Title</label>
  <input type="text" name="title" value="{{ old('title',$blog->title) }}" required>

  <label>Author</label>
  <input type="text" name="author" value="{{ old('author',$blog->author) }}" required>

  <label>Short Description</label>
  <textarea name="short_description" rows="3" required>{{ old('short_description',$blog->short_description) }}</textarea>

  <label>Full Content</label>
  <textarea name="full_content" rows="10" required>{{ old('full_content',$blog->full_content) }}</textarea>

  <label>Current Image</label><br>
  @if($blog->image)
    <img src="{{ asset('storage/'.$blog->image) }}" alt="" style="height:80px"><br>
  @endif

  <label>Replace Image (optional, JPG/PNG ≤ 2MB)</label>
  <input type="file" name="image" accept=".jpg,.jpeg,.png">

  <button class="btn btn-primary" type="submit">Save Changes</button>
  <a class="btn btn-ghost" href="{{ route('admin.blogs.index') }}">Cancel</a>
</form>
@endsection
