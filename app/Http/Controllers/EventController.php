<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'location' => 'required',
            'event_date' => 'required|date',
            'banner' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('events', 'public');
        }

        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'event_date' => $request->event_date,
            'banner' => $bannerPath,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required',
            'location' => 'required',
            'event_date' => 'required|date',
            'banner' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('events', 'public');
            $event->banner = $bannerPath;
        }

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'event_date' => $request->event_date,
            'banner' => $event->banner,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted.');
    }
}

