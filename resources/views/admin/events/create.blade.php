@extends('admin.layout')
@section('title','Create Event')
@section('content')
<div class="grid">
  <div class="col-12">
    <div class="card">
      <h2>Create Event</h2>
      <form method="post" enctype="multipart/form-data" action="{{ route('admin.events.store') }}" style="margin-top:10px">
        @csrf
        <label>Title <input name="title" required class="input" value="{{ old('title') }}"></label>
        <label>Description <textarea name="description" rows="6" class="input">{{ old('description') }}</textarea></label>

        <div class="form-row">
          <label>Location <input name="location" class="input" value="{{ old('location') }}"></label>
          <label>Venue <input name="venue" class="input" value="{{ old('venue') }}"></label>
        </div>

        <div class="form-row">
          <label>Starts at <input type="datetime-local" name="starts_at" required class="input" value="{{ old('starts_at') }}"></label>
          <label>Ends at <input type="datetime-local" name="ends_at" class="input" value="{{ old('ends_at') }}"></label>
        </div>

        <div class="form-row">
          <label>Capacity <input type="number" name="capacity" min="0" class="input" value="{{ old('capacity') }}"></label>
          <label>Price <input type="number" step="0.01" name="price" min="0" class="input" value="{{ old('price', 0) }}"></label>
        </div>

        <label>Purchase option
          <select name="purchase_option" class="input">
            <option value="both" {{ old('purchase_option','both')=='both'?'selected':'' }}>Both</option>
            <option value="pay_now" {{ old('purchase_option')=='pay_now'?'selected':'' }}>Pay now</option>
            <option value="pay_later" {{ old('purchase_option')=='pay_later'?'selected':'' }}>Pay later</option>
          </select>
        </label>

        <label>Banner <input type="file" name="banner" accept="image/*" class="input"></label>

        <div style="display:flex; gap:10px; flex-wrap:wrap">
          <button type="submit" class="btn btn-primary">Save</button>
          <a href="{{ route('admin.events.index') }}" class="btn btn-ghost">Back</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
