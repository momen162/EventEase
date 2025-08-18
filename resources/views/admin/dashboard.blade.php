@extends('admin.layout')
@section('title','Dashboard')
@section('content')
<div class="grid" style="background-color:#f8f9fa; min-height:100vh; padding:30px;">
  <div class="col-12">
    <div class="card" 
         style="background:#ffffff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.08); padding:25px;">
      <h2 style="margin-bottom:8px; color:#333;">Welcome, {{ auth()->user()->name }}</h2>
      <p class="help" style="color:#666; font-size:15px;">Quick links to common tasks.</p>
      
      <div style="display:flex; gap:15px; flex-wrap:wrap; margin-top:20px">
        <a class="btn" 
           style="background:#4e73df; color:#fff; padding:10px 18px; border-radius:8px; 
                  font-weight:500; text-decoration:none; transition:0.3s;" 
           href="{{ route('admin.users.index') }}"
           onmouseover="this.style.background='#2e59d9'" 
           onmouseout="this.style.background='#4e73df'">
           Manage Users
        </a>

        <a class="btn" 
           style="background:#1cc88a; color:#fff; padding:10px 18px; border-radius:8px; 
                  font-weight:500; text-decoration:none; transition:0.3s;" 
           href="{{ route('admin.events.index') }}"
           onmouseover="this.style.background='#17a673'" 
           onmouseout="this.style.background='#1cc88a'">
           Manage Events
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
