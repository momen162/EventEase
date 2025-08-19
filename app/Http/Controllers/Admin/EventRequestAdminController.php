<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventRequestAdminController extends Controller
{
    /**
     * Pending event requests list (with optional filters used by the Blade).
     */
    public function index(Request $request)
    {
        $eventId = (int) $request->input('event_id', 0);
        $q       = trim((string) $request->input('q', ''));
        $from    = $request->input('from', '');
        $to      = $request->input('to', '');

        $rows = Event::with('creator:id,name,email')
            ->where('status', 'pending')
            ->when($eventId > 0, fn ($qq) => $qq->where('id', $eventId))
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('title', 'like', "%{$q}%")
                      ->orWhere('location', 'like', "%{$q}%");
                });
            })
            ->when(is_string($from) && trim($from) !== '', fn ($qq) => $qq->whereDate('starts_at', '>=', $from))
            ->when(is_string($to)   && trim($to)   !== '', fn ($qq) => $qq->whereDate('starts_at', '<=', $to))
            ->orderBy('starts_at')
            ->get();

        // For the Event dropdown in Blade
        $events = Event::select('id', 'title')->orderByDesc('starts_at')->get();

        return view('admin.requests.index', compact('rows', 'events'));
    }

    public function approve(Event $event)
    {
        abort_unless($event->status === 'pending', 400);

        $event->update([
            'status'       => 'approved',
            'approved_by'  => auth()->id(),
            'approved_at'  => now(),
        ]);

        return back()->with('success', "Event #{$event->id} approved.");
    }

    public function reject(Event $event)
    {
        abort_unless($event->status === 'pending', 400);

        $event->update([
            'status'       => 'rejected',
            'approved_by'  => auth()->id(),
            'approved_at'  => now(),
        ]);

        return back()->with('success', "Event #{$event->id} rejected.");
    }
}
