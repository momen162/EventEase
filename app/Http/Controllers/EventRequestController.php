<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventRequestController extends Controller
{
    public function create()
    {
        return view('events.request');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'location'    => 'nullable|string|max:255',
            'starts_at'   => 'required|date|after:now',
            'ends_at'     => 'nullable|date|after_or_equal:starts_at',
            'capacity'    => 'nullable|integer|min:1',
        ]);

        Event::create([
            'title'       => $request->title,
            'description' => $request->description,
            'location'    => $request->location,
            'starts_at'   => $request->starts_at,
            'ends_at'     => $request->ends_at,
            'capacity'    => $request->capacity,
            'created_by'  => Auth::id(),
            'status'      => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Event request submitted. An admin will review it.');
    }
}
