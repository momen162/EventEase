<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * GET /payments/redirect
     * Create a payment session with your provider and redirect there.
     * Replace the stub with your gateway integration (SSLCommerz/bKash/Stripe/etc).
     */
    public function redirect(Request $request)
    {
        $checkout = session('checkout');
        abort_unless($checkout && auth()->id() === $checkout['user_id'], 403);

        // TODO: Implement your payment provider redirect here.
        // Example:
        // $session = $gateway->createCheckout([...]);
        // return redirect()->away($session->url);

        // DEV STUB: simulate success immediately
        return redirect()->route('payments.success');
    }

    /**
     * GET /payments/callback/success
     * Verify payment and create the ticket as PAID.
     */
    public function success(Request $request)
    {
        $checkout = session('checkout');
        abort_unless($checkout && auth()->id() === $checkout['user_id'], 403);

        // TODO: Verify transaction with your gateway before proceeding.

        $event = Event::findOrFail($checkout['event_id']);
        /** @var \App\Http\Controllers\TicketController $ticketController */
        $ticketController = app(\App\Http\Controllers\TicketController::class);

        // Create ticket as PAID after successful payment
        $ticket = $ticketController->createTicketAndQr($event, (int)$checkout['qty'], 'pay_now', 'paid');

        session()->forget('checkout');

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Payment successful. Your ticket is ready!');
    }

    /**
     * GET /payments/callback/cancel
     */
    public function cancel(Request $request)
    {
        $eventId = optional(session('checkout'))['event_id'];
        $qty     = optional(session('checkout'))['qty'];
        session()->forget('checkout');

        if ($eventId) {
            return redirect()->route('tickets.checkout', ['event_id' => $eventId, 'qty' => $qty])
                ->with('error', 'Payment was cancelled.');
        }

        return redirect()->route('events.index')->with('error', 'Payment was cancelled.');
    }
}
