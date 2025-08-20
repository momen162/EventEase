<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketController extends Controller
{
    public function buy(Event $event)
    {
        return view('tickets.buy', compact('event'));
    }

    public function checkout(Request $request, Event $event)
    {
        $validated = $request->validate([
            'quantity' => ['required','integer','min:1','max:50'],
            'payment_method' => ['required','in:pay_now,pay_later'],
        ]);

        $code = 'TKT-'.strtoupper(Str::random(6));
        $total = $event->price * $validated['quantity'];

        $ticket = Ticket::create([
            'user_id'       => $request->user()->id,
            'event_id'      => $event->id,
            'quantity'      => $validated['quantity'],
            'total_amount'  => $total,
            'payment_method'=> $validated['payment_method'],
            'status'        => $validated['payment_method']==='pay_now' ? 'paid' : 'unpaid',
            'code'          => $code,
        ]);

        $dir = 'tickets';
        Storage::makeDirectory($dir);
        $path = $dir.'/'.$code.'.png';
        $qrContent = route('tickets.show', $ticket);
        Storage::put($path, QrCode::format('png')->size(250)->generate($qrContent));

        $ticket->update(['qr_path' => $path]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Your ticket has been generated.');
    }

    public function show(Ticket $ticket)
    {
        if(auth()->id() !== $ticket->user_id){
            abort(403);
        }
        return view('tickets.show', compact('ticket'));
    }
}
