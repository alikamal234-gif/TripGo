<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function method(Request $request)
    {
        $data = $request->validate([
            'method' => ['required', Rule::in(['cash', 'online'])],
            'amount' => ['required', 'numeric', 'min:0'],
            'trip_id' => ['required', 'exists:trips,id'],
        ]);

        if ($data['method'] == 'cash') {
            return $this->cash($data);
        }
    }

    public function cash($data)
    {
        Payment::create([
            'amount' => $data['amount'],
            'method' => 'cash',
            'passenger_id' => auth()->id(),
            'status' => 'pending',
            'trip_id' => $data['trip_id'],
            'paid_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Paiement effectué attente pour le driver complete le confirmation');
    }

    public function confirme(string $id)
    {
        if (! auth()->user()->is_driver()) {
            abort(403);
        }
        $payment = Payment::where('trip_id', $id);
        $payment->update([
            'status' => 'paid',
        ]);

        return redirect()->route('driver.dashboard');
    }

    public function createIntent(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
        ]);

        $trip = Trip::findOrFail($request->trip_id);

        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = PaymentIntent::create([
            'amount' => (int) ($trip->price * 100),
            'currency' => 'eur',
            'payment_method_types' => ['card'],
            'metadata' => ['trip_id' => $trip->id],
        ]);

        return response()->json([
            'clientSecret' => $intent->client_secret,
        ]);
    }

    public function success(Request $request)
    {
        $trip = Trip::findOrFail($request->trip_id);

        Payment::create([
            'trip_id' => $trip->id,
            'passenger_id' => $trip->passenger_id,
            'amount' => $trip->price,
            'status' => 'paid',
            'method' => 'online',
            'paid_at' => now(),
        ]);

        return redirect()->route('passenger.dashboard')
            ->with('success', 'Paiement effectué');
    }

    public function historique()
    {
        $payments = Payment::where('passenger_id', auth()->id())->get();

        // dd($payments);
        return view('payments.historique', compact('payments'));
    }
}
