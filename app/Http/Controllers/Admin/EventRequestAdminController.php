<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventRequestAdminController extends Controller
{
    public function index()
    {
        $rows = Event::with('creator:id,name,email')
            ->where('status','pending')
            ->orderBy('starts_at')
            ->get();
        return view('admin.requests.index', compact('rows'));
    }

    public function approve(Event $event)
    {
        abort_unless($event->status === 'pending', 400);
        $event->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        return back();
    }

    public function reject(Event $event)
    {
        abort_unless($event->status === 'pending', 400);
        $event->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        return back();
    }
}
