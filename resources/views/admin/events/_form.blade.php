<div class="form-group">
  <label for="title">Event Title</label>
  <input type="text" name="title" id="title" value="{{ old('title', $event->title ?? '') }}" required>
</div>

<div class="form-group">
  <label for="description">Description</label>
  <textarea name="description" id="description" rows="5" required>{{ old('description', $event->description ?? '') }}</textarea>
</div>

<div class="form-group">
  <label for="location">Location</label>
  <input type="text" name="location" id="location" value="{{ old('location', $event->location ?? '') }}" required>
</div>

<div class="form-group">
  <label for="date">Date</label>
  <input type="date" name="date" id="date" value="{{ old('date', $event->date ?? '') }}" required>
</div>

<div class="form-group">
  <label for="time">Time</label>
  <input type="time" name="time" id="time" value="{{ old('time', $event->time ?? '') }}" required>
</div>

<div class="form-group">
  <label for="price">Ticket Price</label>
  <input type="number" name="price" id="price" value="{{ old('price', $event->price ?? '') }}" step="0.01" required>
</div>

<div class="form-group">
  <label for="image">Event Image</label>
  <input type="file" name="image" id="image" {{ isset($event) ? '' : 'required' }}>
  
  @if(isset($event) && $event->image)
    <div class="image-preview">
      <p>Current Image:</p>
      <img src="{{ asset('storage/events/' . $event->image) }}" alt="Event Image" style="max-width: 200px;">
    </div>
  @endif
</div>
