<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketController extends Controller
{
    // Display quantity + payment option form
    public function buy(Event $event)
    {
        return view('events-buy', compact('event'));
    }

    // Handle checkout
    public function checkout(Request $request, Event $event)
    {
        $data = $request->validate([
            'quantity' => ['required','integer','min:1','max:100'],
            'payment_option' => ['required','in:pay_now,pay_later'],
        ]);

        $total = $event->price * $data['quantity'];
        $ticketCode = 'TKT-'.strtoupper(Str::random(8));

        $ticket = Ticket::create([
            'user_id'        => $request->user()->id,
            'event_id'       => $event->id,
            'quantity'       => $data['quantity'],
            'total_amount'   => $total,
            'payment_option' => $data['payment_option'],
            'payment_status' => $data['payment_option'] === 'pay_now' ? 'paid' : 'unpaid',
            'ticket_code'    => $ticketCode,
        ]);

        // Generate QR (PNG saved to /storage/app/public/tickets/)
        $qrDir = 'tickets';
        Storage::makeDirectory($qrDir);
        $qrPath = $qrDir.'/'.$ticketCode.'.png';
        $payload = route('tickets.show', $ticket); // what scanning reveals
        Storage::put($qrPath, QrCode::format('png')->size(300)->generate($payload));
        $ticket->update(['qr_path' => $qrPath]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', $data['payment_option']==='pay_now'
                ? 'Payment successful! Ticket generated.'
                : 'Reservation confirmed. Pay later selected; ticket generated.');
    }

    // Show ticket (only owner)
    public function show(Ticket $ticket)
    {
        $this->authorizeTicket($ticket);
        return view('ticket', compact('ticket'));
    }

    protected function authorizeTicket(Ticket $ticket)
    {
        if (auth()->id() !== $ticket->user_id) {
            abort(403);
        }
    }
}
