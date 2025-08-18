<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // GET /payments/manual
    public function manual(Request $request)
    {
        $checkout = session('checkout');
        abort_unless($checkout && auth()->id() === $checkout['user_id'], 403);

        $event = Event::findOrFail($checkout['event_id']);

        // Put your real numbers in .env (see below)
        $bkash  = env('PAY_BKASH',  '017XXXXXXXX');
        $nagad  = env('PAY_NAGAD',  '018XXXXXXXX');
        $rocket = env('PAY_ROCKET', '01XXXXXXXXX');

        return view('payments.manual', compact('event', 'checkout', 'bkash', 'nagad', 'rocket'));
    }

    // POST /payments/manual/confirm
    public function manualConfirm(Request $request)
    {
        $checkout = session('checkout');
        abort_unless($checkout && auth()->id() === $checkout['user_id'], 403);

        $event = Event::findOrFail($checkout['event_id']);

        // If you prefer to verify payment first, change 'paid' -> 'unpaid'
        $ticket = app(\App\Http\Controllers\TicketController::class)
            ->createTicketAndQr($event, (int)$checkout['qty'], 'pay_now', 'paid');

        session()->forget('checkout');

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Thanks! Your ticket is ready.');
    }
}
