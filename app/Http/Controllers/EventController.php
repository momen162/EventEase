<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'approved')
            ->orderByDesc('starts_at')
            ->paginate(9);

        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        if ($event->status !== 'approved') {
            $user = Auth::user();
            if (!$user || (!$user->isAdmin() && $user->id !== $event->created_by)) {
                abort(404);
            }
        }
        return view('events.show', compact('event'));
    }
}
