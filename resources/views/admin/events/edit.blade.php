@extends('admin.layout')
@section('title','Edit Event #'.$event->id)
@section('content')
@php
  $dt = fn($s)=> $s ? str_replace(' ', 'T', substr($s, 0, 16)) : '';
@endphp
<div class="grid">
  <div class="col-12">
    <div class="card">
      <h2>Edit Event #{{ $event->id }}</h2>

      @if ($errors->any())
        <div class="card" style="background:#fee2e2;border:1px solid #fecaca;margin-top:14px">
          <strong style="color:#b91c1c">Error:</strong>
          <ul style="margin:8px 0 0 16px">
            @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
          </ul>
        </div>
      @endif

      <form method="post" enctype="multipart/form-data" action="{{ route('admin.events.update',$event) }}" style="margin-top:10px">
        @csrf @method('PUT')

        <label>Title
          <input name="title" value="{{ old('title',$event->title) }}" required class="input">
        </label>

        <label>Description
          <textarea name="description" rows="6" class="input">{{ old('description',$event->description) }}</textarea>
        </label>

        <div class="form-row">
          <label>Location <input name="location" value="{{ old('location',$event->location) }}" class="input"></label>
          <label>Venue <input name="venue" value="{{ old('venue',$event->venue) }}" class="input"></label>
        </div>

        <div class="form-row">
          <label>Starts at <input type="datetime-local" name="starts_at" value="{{ old('starts_at',$dt($event->starts_at)) }}" class="input"></label>
          <label>Ends at <input type="datetime-local" name="ends_at" value="{{ old('ends_at',$dt($event->ends_at)) }}" class="input"></label>
        </div>

        <div class="form-row">
          <label>Capacity <input type="number" name="capacity" min="0" value="{{ old('capacity',$event->capacity) }}" class="input"></label>
          <label>Price <input type="number" step="0.01" name="price" min="0" value="{{ old('price',$event->price) }}" class="input"></label>
        </div>

        <label>Purchase option
          @php $opt = old('purchase_option',$event->purchase_option ?? 'both'); @endphp
          <select name="purchase_option" class="input">
            <option value="both" {{ $opt==='both'?'selected':'' }}>Both</option>
            <option value="pay_now" {{ $opt==='pay_now'?'selected':'' }}>Pay now</option>
            <option value="pay_later" {{ $opt==='pay_later'?'selected':'' }}>Pay later</option>
          </select>
        </label>

        <div style="margin:10px 0">
          <strong>Current banner:</strong><br>
          @if ($event->banner)
            <img src="{{ $event->banner }}" alt="banner" class="preview"><br>
            <label style="display:inline-flex; gap:8px; align-items:center; margin-top:8px">
              <input type="checkbox" name="remove_banner" value="1"> Remove current banner
            </label>
          @else
            <em class="help">No banner uploaded</em><br>
          @endif
        </div>

        <label>Replace banner
          <input type="file" name="banner" accept="image/*" class="input">
        </label>

        <div style="display:flex; gap:10px; flex-wrap:wrap">
          <button type="submit" class="btn btn-primary">Update</button>
          <a href="{{ route('admin.events.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
