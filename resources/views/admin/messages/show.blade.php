@extends('admin.layout')
@section('title','Message #'.$contact->id)
@section('content')
<h1>Message #{{ $contact->id }}</h1>

<div class="card">
  <p><strong>Name:</strong> {{ $contact->name }}</p>
  <p><strong>Email:</strong> <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
  <p><strong>Received:</strong> {{ $contact->created_at }}</p>
  <p><strong>Message:</strong></p>
  <pre class="pre-wrap">{{ $contact->message }}</pre>
</div>

<h2>Reply</h2>
@if (session('sent'))
  <div class="card" style="background:#ecfdf5;border:1px solid #a7f3d0;margin-top:14px">
    <strong style="color:#065f46">Reply email sent.</strong>
  </div>
@endif

<form method="POST" action="{{ route('admin.messages.reply', $contact) }}" class="form">
  @csrf
  <label>To</label>
  <input type="email" name="to" value="{{ $contact->email }}" readonly>

  <label>Subject</label>
  <input type="text" name="subject" value="Re: Your message to EventEase" required>

  <label>Message</label>
  <textarea name="body" rows="8" required></textarea>

  <button class="btn btn-primary" type="submit">Send Reply</button>
</form>

<p style="margin-top:14px"><a href="{{ route('admin.messages.index') }}">&larr; Back to list</a></p>
@endsection
