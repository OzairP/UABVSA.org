<?php

namespace App\Http\Controllers;

use App\Http\Requests\Lotus\LotusReserveTicketRequest;
use App\Mail\Lotus\SendReservationTicket;
use App\Mail\Lotus\VerifyUABEmail;
use App\Models\LotusReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Checkout;
use Log;
use Mail;

class LotusReservationsController extends Controller
{

    public function index ()
    {
        return view('lotus.index');
    }

    public function reserve (LotusReserveTicketRequest $request)
    {
        Log::info('Reserving ticket for ' . $request->get('email'));

        // If the user is a student, set their reserved tickets to 1
        if ($request->get('holder_type') === 'student') {
            $request->merge([
                'tickets' => 1,
            ]);
        }

        if ($reservation = LotusReservation::whereEmail($request->get('email'))
                                           ->first()) {
            Log::info('Reservation already exists for ' . $request->get('email'));
            $reservation->delete();
            Log::info('Reservation deleted for ' . $request->get('email'));
        }

        $reservation = LotusReservation::createPendingReservation($request->validated());
        Log::info('Reservation created: ' . $reservation->id);

        if ($request->isStudent()) {
            return $this->reserveForStudent($reservation);
        }

        return $this->reserveForPayment($reservation);
    }

    /**
     * @param \App\Models\LotusReservation $reservation
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    private function reserveForStudent (LotusReservation $reservation)
    {
        $signedVerifyURL = URL::temporarySignedRoute('lotus.verification.complete', now()->addMinutes(10), ['reservation' => $reservation->id]);
        Log::info('Sending verification email to ' . $reservation->email . ' with URL ' . $signedVerifyURL);

        Mail::to($reservation->email)
            ->send(new VerifyUABEmail($signedVerifyURL));

        return view('lotus.reserving.verify', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @param \App\Models\LotusReservation $reservation
     *
     * @return \Laravel\Cashier\Checkout
     */
    private function reserveForPayment (LotusReservation $reservation): Checkout
    {
        Log::info('Reserving ticket for ' . $reservation->email . ' with Stripe');

        return Checkout::guest()
                       ->create([
                           nova_get_setting('lotus_stripe_product_id') => $reservation->tickets,
                       ], [
                           'success_url' => route('lotus.payment.success', [
                                   'reservation' => $reservation->id,
                               ]) . '&session_id={CHECKOUT_SESSION_ID}',
                           'cancel_url'  => route('lotus.payment.cancel', [
                               'reservation' => $reservation->id,
                           ]),
                       ]);
    }

    public function completeVerification (Request $request)
    {
        Log::info('Completing student verification for ' . $request->get('reservation'));
        if (!$request->hasValidSignature()) {
            Log::warning('Invalid signature for reservation ' . $request->get('reservation'));

            return response()
                ->view('lotus.reserving.expired')
                ->setStatusCode(401);
        }

        $reservationId = $request->get('reservation');
        $reservation = LotusReservation::findOrFail($reservationId);
        $reservation->markAsNotPending();
        Log::info('Reservation ' . $reservation->id . ' marked as not pending');

        Mail::send(new SendReservationTicket($reservation));
        Log::info('Reservation ticket sent to ' . $reservation->email);

        Session::put('reservation', $reservation->id);

        return view('lotus.reserving.success', [
            'reservation' => $reservation,
            'downloadLink' => URL::signedRoute('lotus.reserve.download', [
                'reservation' => $reservation->id,
            ]),
        ]);
    }

    public function paymentSuccess (Request $request)
    {
        Log::info('Payment success for ' . $request->get('reservation'));
        $reservation = LotusReservation::findOrFail($request->get('reservation'));
        $checkoutSession = Cashier::stripe()->checkout->sessions->retrieve($request->get('session_id'));

        if ($checkoutSession->payment_status !== 'paid') {
            Log::warning('Checkout session status not paid for ' . $reservation->id, [
                'checkoutSession' => $checkoutSession,
            ]);

            return redirect()->route('lotus.payment.cancel', [
                'reservation' => $reservation->id,
            ]);
        }

        if ($reservation->isNotPending()) {
            Log::warning('Reservation not pending for ' . $reservation->id);
            abort(401);
        }

        $reservation->markAsPaid($checkoutSession->payment_intent, $checkoutSession->amount_total);
        Log::info('Reservation ' . $reservation->id . ' marked as paid');

        Mail::send(new SendReservationTicket($reservation));
        Log::info('Reservation ticket sent to ' . $reservation->email);

        Session::put('reservation', $reservation->id);

        return view('lotus.reserving.success', [
            'reservation' => $reservation,
            'downloadLink' => URL::signedRoute('lotus.reserve.download', [
                'reservation' => $reservation->id,
            ]),
        ]);
    }

    public function paymentCancel (Request $request)
    {
        Log::info('Payment cancelled for ' . $request->get('reservation'));
        $reservation = LotusReservation::findOrFail($request->get('reservation'));

        if ($reservation->isNotPending()) {
            Log::warning('Reservation not pending for ' . $reservation->id);
            abort(401);
        }

        $reservation->delete();
        Log::info('Reservation ' . $reservation->id . ' deleted');

        return view('lotus.reserving.cancel');
    }

    public function donate ()
    {
        $reservationId = NULL;

        if (Session::has('reservation')) {
            $reservation = LotusReservation::find(Session::get('reservation'));
            $reservationId = $reservation->id;
        }

        return Checkout::guest()
                       ->create(['price_1MJ3XNG3vywsysV9lt9LFxUX'], [
                           'success_url' => route('lotus.donate.success', [
                                   'reservation' => $reservationId,
                               ]) . '&session_id={CHECKOUT_SESSION_ID}',
                           'cancel_url'  => route('home'),
                       ]);
    }

    public function donationSuccess (Request $request)
    {
        Log::info('Donation success for ' . $request->get('reservation'));
        $reservation = LotusReservation::find($request->get('reservation'));
        $checkoutSession = Cashier::stripe()->checkout->sessions->retrieve($request->get('session_id'));

        if ($checkoutSession->payment_status !== 'paid') {
            Log::warning('Checkout session status not paid', [
                'reservation'     => $reservation,
                'checkoutSession' => $checkoutSession,
            ]);

            return redirect()->route('home');
        }

        if ($reservation) {
            $reservation->donation = $checkoutSession->amount_total;
            $reservation->donation_stripe_payment_id = $checkoutSession->payment_intent;
            $reservation->save();
        }

        return view('lotus.reserving.donated');
    }

    public function downloadReservation (Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $reservation = LotusReservation::findOrFail($request->get('reservation'));

        return $reservation->generatePDF()->stream('Lotus Reservation (' . $reservation->name . ').pdf');
    }

}
