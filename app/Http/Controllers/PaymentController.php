<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function method(Request $request){
        $data = $request->validate([
            'method' => ['required', Rule::in(['cash','online'])],
            'amount' => ['required','numeric','min:0'],
            'driver_id' => ['required','exists:drivers,id'],
            'passenger_id' => ['required','exists:passengers,id'],
            'trip_id' => ['required','exists:trips,id'],
        ]);

        if($data['method'] == "cash"){
            return $this->cash($data);
        }else if($data['method'] == "online"){
            return $this->online($data);
        }
    }

    public function cash($data){
        Payment::create([
            'amount' => $data['amount'],
            'driver_id' => $data['driver_id'],
            'method' => "cash",
            'passenger_id' => auth()->id(),
            'status' => "pending",
            'trip_id' =>$data['trip_id'],
            'paid_at' => now()
        ]);
        return redirect()->back();
    }

    public function online($data){

    }
    public function confirme(string $id){
        $payment = Payment::findOrFail($id);
        $payment->update([
            'status' => "paid"
        ]);
        return redirect()->back();
    }
}
