<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    // POST /events/{event}/buy  -> requires login (redirects to login if guest)
    public function start(Request $request, Event $event)
    {
        $qty = max(1, (int)$request->input('quantity', 1));

        if (!auth()->check()) {
            return redirect()->route('login')->with('status', 'Please log in to buy tickets.');
        }

        return redirect()->route('tickets.checkout', [
            'event_id' => $event->id,
            'qty'      => $qty,
        ]);
    }

    // GET /checkout?event_id=&qty=   (shows Pay now / Pay later)
    public function checkout(Request $request)
    {
        $event = Event::findOrFail($request->integer('event_id'));
        $qty   = max(1, (int)$request->integer('qty', 1));
        $total = $event->price * $qty;

        $allowed = match($event->purchase_option ?? 'both') {
            'pay_now'   => ['pay_now'],
            'pay_later' => ['pay_later'],
            default     => ['pay_now','pay_later'],
        };

        return view('tickets.checkout', compact('event','qty','total','allowed'));
    }

    // POST /checkout/confirm  -> creates ticket, generates QR, redirects to ticket page
    public function confirm(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'qty'      => 'required|integer|min:1',
            'method'   => 'required|in:pay_now,pay_later',
        ]);

        $event   = Event::findOrFail($request->integer('event_id'));
        $qty     = (int)$request->input('qty');
        $method  = $request->string('method');
        $total   = $event->price * $qty;

        $ticket = Ticket::create([
            'user_id'        => auth()->id(),
            'event_id'       => $event->id,
            'quantity'       => $qty,
            'total_amount'   => $total,
            'payment_option' => $method,
            'payment_status' => $method === 'pay_now' ? 'paid' : 'unpaid',
            'ticket_code'    => 'TKT-' . strtoupper(Str::random(8)),
        ]);

// Generate QR **SVG** and save under storage/app/public/tickets/
    $svg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
        ->size(260)
        ->generate($ticket->ticket_code);

    $path = 'tickets/'.$ticket->ticket_code.'.svg';
    \Illuminate\Support\Facades\Storage::disk('public')->put($path, $svg);

    $ticket->qr_path = $path;
    $ticket->save();

        return redirect()->route('tickets.show', $ticket);
    }

    // GET /tickets/{ticket} -> show ticket page
    public function show(Ticket $ticket)
    {
        abort_unless(auth()->check() && auth()->id() === $ticket->user_id, 403);
        return view('tickets.show', compact('ticket'));
    }

    // GET /tickets/{ticket}/download -> stream PDF
    public function download(Ticket $ticket)
    {
        abort_unless(auth()->check() && auth()->id() === $ticket->user_id, 403);

        $pdf = Pdf::loadView('tickets.pdf', ['ticket' => $ticket]);
        return $pdf->download($ticket->ticket_code.'.pdf');
    }
}
