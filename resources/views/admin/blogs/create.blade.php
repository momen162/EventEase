@extends('admin.layout')
@section('title','New Blog')
@section('content')
<h1>New Blog</h1>
<form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data" class="form">
  @csrf
  <label>Title</label>
  <input type="text" name="title" required>

  <label>Author</label>
  <input type="text" name="author" required>

  <label>Short Description</label>
  <textarea name="short_description" rows="3" maxlength="500" required></textarea>

  <label>Full Content</label>
  <textarea name="full_content" rows="10" required></textarea>

  <label>Image (JPG/PNG, ≤ 2MB)</label>
  <input type="file" name="image" accept=".jpg,.jpeg,.png" required>

  <button class="btn btn-primary" type="submit">Create</button>
  <a class="btn btn-ghost" href="{{ route('admin.blogs.index') }}">Cancel</a>
</form>
@endsection
