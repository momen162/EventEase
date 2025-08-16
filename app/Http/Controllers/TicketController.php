<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
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

    /**
     * POST /checkout/confirm
     * - pay_later: create ticket immediately (as before)
     * - pay_now:   DO NOT create ticket; store checkout in session & redirect to payment redirector
     */
    public function confirm(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'required|exists:events,id',
            'qty'      => 'required|integer|min:1',
            'method'   => 'required|in:pay_now,pay_later',
        ]);

        $event  = Event::findOrFail((int)$data['event_id']);
        $qty    = (int)$data['qty'];
        $method = $data['method'];

        if ($method === 'pay_later') {
            // Create the ticket immediately (unpaid)
            $ticket = $this->createTicketAndQr($event, $qty, 'pay_later', 'unpaid');
            return redirect()->route('tickets.show', $ticket);
        }

        // PAY NOW: defer ticket creation until gateway success.
        // Stash minimal checkout info in session (or create a Payment record if you prefer).
        session()->put('checkout', [
            'event_id' => $event->id,
            'qty'      => $qty,
            'user_id'  => auth()->id(),
            'total'    => $event->price * $qty,
        ]);

        // Hand off to gateway redirector
        return redirect()->route('payments.redirect');
    }

    public function show(Ticket $ticket)
    {
        abort_unless(auth()->check() && auth()->id() === $ticket->user_id, 403);
        return view('tickets.show', compact('ticket'));
    }

    public function download(Ticket $ticket)
    {
        abort_unless(auth()->check() && auth()->id() === $ticket->user_id, 403);

        $pdf = Pdf::loadView('tickets.pdf', ['ticket' => $ticket]);
        return $pdf->download($ticket->ticket_code.'.pdf');
    }

    /**
     * Helper: creates ticket, generates SVG QR into storage/app/public/tickets/
     */
    private function createTicketAndQr(Event $event, int $qty, string $paymentOption, string $paymentStatus): Ticket
    {
        $total = $event->price * $qty;

        $ticket = Ticket::create([
            'user_id'        => auth()->id(),
            'event_id'       => $event->id,
            'quantity'       => $qty,
            'total_amount'   => $total,
            'payment_option' => $paymentOption, // 'pay_now' | 'pay_later'
            'payment_status' => $paymentStatus, // 'paid' | 'unpaid'
            'ticket_code'    => 'TKT-' . strtoupper(Str::random(8)),
        ]);

        // Generate QR SVG
        $svg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
            ->size(260)
            ->generate($ticket->ticket_code);

        $path = 'tickets/'.$ticket->ticket_code.'.svg';
        Storage::disk('public')->put($path, $svg);

        $ticket->qr_path = $path;
        $ticket->save();

        return $ticket;
    }
}
