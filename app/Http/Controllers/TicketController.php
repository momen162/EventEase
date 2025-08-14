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
    // Show purchase form
    public function buy(Event $event)
    {
        return view('events-buy', ['event' => $event]);
    }

    // Process ticket order + payment
    public function checkout(Request $request, Event $event)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:100'],
            'payment_option' => ['required', 'in:pay_now,pay_later'],
        ]);

        $amount = $event->price * $validated['quantity'];
        $code = 'TKT-' . strtoupper(Str::random(8));

        $ticket = Ticket::create([
            'user_id'        => $request->user()->id,
            'event_id'       => $event->id,
            'quantity'       => $validated['quantity'],
            'total_amount'   => $amount,
            'payment_option' => $validated['payment_option'],
            'payment_status' => $validated['payment_option'] === 'pay_now' ? 'paid' : 'unpaid',
            'ticket_code'    => $code,
        ]);

        // Generate and save QR code
        $folder = 'tickets';
        Storage::makeDirectory($folder);
        $path = $folder . '/' . $code . '.png';
        $content = route('tickets.show', $ticket);
        Storage::put($path, QrCode::format('png')->size(300)->generate($content));
        $ticket->update(['qr_path' => $path]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', $validated['payment_option'] === 'pay_now'
                ? 'Payment completed. Ticket ready!'
                : 'Booking done. Pay later option chosen; ticket prepared.');
    }

    // Display ticket if user owns it
    public function show(Ticket $ticket)
    {
        $this->ensureOwnership($ticket);
        return view('ticket', ['ticket' => $ticket]);
    }

    protected function ensureOwnership(Ticket $ticket)
    {
        if (auth()->id() !== $ticket->user_id) {
            abort(403);
        }
    }
}
