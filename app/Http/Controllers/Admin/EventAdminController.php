<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventAdminController extends Controller
{
    public function index()
    {
        $events = Event::select('id','title','location','starts_at','ends_at','capacity')
                       ->orderByDesc('starts_at')->get();
        return view('admin.events.index', compact('events'));
    }

    public function create() { return view('admin.events.create'); }

    public function store(Request $r)
    {
        $data = $r->validate([
            'title'=>'required|string',
            'description'=>'nullable|string',
            'location'=>'nullable|string',
            'venue'=>'nullable|string',
            'starts_at'=>'required|date',
            'ends_at'=>'nullable|date|after_or_equal:starts_at',
            'capacity'=>'nullable|integer|min:0',
            'price'=>'nullable|numeric|min:0',
            'purchase_option'=>'required|in:both,pay_now,pay_later',
            'banner'=>'nullable|image',
        ]);

        $bannerPath = null;
        if ($r->hasFile('banner')) {
            $file = 'ev_'.time().'_'.mt_rand(1000,9999).'.'.$r->file('banner')->extension();
            $r->file('banner')->move(public_path('uploads/events'), $file);
            $bannerPath = '/uploads/events/'.$file; // matches your legacy path
        }

        Event::create($data + [
            'banner' => $bannerPath,
            'created_by' => auth()->id(),
            'status' => 'approved', // or 'pending' if you want manual approve
        ]);

        return redirect()->route('admin.events.index');
    }

    public function edit(Event $event) { return view('admin.events.edit', compact('event')); }

    public function update(Request $r, Event $event)
    {
        $data = $r->validate([
            'title'=>'required|string',
            'description'=>'nullable|string',
            'location'=>'nullable|string',
            'venue'=>'nullable|string',
            'starts_at'=>'nullable|date',
            'ends_at'=>'nullable|date|after_or_equal:starts_at',
            'capacity'=>'nullable|integer|min:0',
            'price'=>'nullable|numeric|min:0',
            'purchase_option'=>'required|in:both,pay_now,pay_later',
            'remove_banner'=>'nullable|boolean',
            'banner'=>'nullable|image',
        ]);

        $bannerPath = $event->banner;
        if ($r->hasFile('banner')) {
            if ($event->banner && is_file(public_path($event->banner))) @unlink(public_path($event->banner));
            $file = 'ev_'.time().'_'.mt_rand(1000,9999).'.'.$r->file('banner')->extension();
            $r->file('banner')->move(public_path('uploads/events'), $file);
            $bannerPath = '/uploads/events/'.$file;
        } elseif ($r->boolean('remove_banner')) {
            if ($event->banner && is_file(public_path($event->banner))) @unlink(public_path($event->banner));
            $bannerPath = null;
        }

        $event->update($data + ['banner'=>$bannerPath]);
        return redirect()->route('admin.events.index');
    }

    public function destroy(Event $event)
    {
        if ($event->banner && is_file(public_path($event->banner))) @unlink(public_path($event->banner));
        // cascade deletes tickets if FK is set to cascade, mirrors your legacy cleanup. :contentReference[oaicite:13]{index=13}:contentReference[oaicite:14]{index=14}
        $event->delete();
        return redirect()->route('admin.events.index');
    }
}
