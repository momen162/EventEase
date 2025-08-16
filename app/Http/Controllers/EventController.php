<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
        public function index()
        {
            $events = \App\Models\Event::orderByDesc('starts_at')->paginate(9);
            return view('events.index', compact('events')); // <-- not 'events'
        }


        public function show(Event $event)
        {
            return view('events.show', compact('event'));
        }


}
