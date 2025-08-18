<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessageAdminController extends Controller
{
    public function index()
    {
        $rows = Contact::select('id','name','email','created_at')->orderByDesc('id')->paginate(20);
        return view('admin.messages.index', compact('rows'));
    }

    public function show(Contact $contact)
    {
        return view('admin.messages.show', compact('contact'));
    }

    public function reply(Request $r, Contact $contact)
    {
        $data = $r->validate([
            'subject'=>'required|string',
            'body'=>'required|string',
        ]);

        Mail::raw($data['body'], function ($m) use ($contact, $data) {
            $m->to($contact->email, $contact->name)->subject($data['subject']);
        });

        return back()->with('sent', true);
    }
}
