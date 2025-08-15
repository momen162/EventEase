<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderByDesc('starts_at')->paginate(9);
        return view('events', compact('events')); // use your existing events.blade.php
    }

    public function show(Event $event)
    {
        return view('event-details', compact('event'));
    }
}
