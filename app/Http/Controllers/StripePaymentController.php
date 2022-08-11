<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session ;
use Stripe\CheckOut;
use Stripe\Stripe as StripeStripe;

class StripePaymentController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function checkout(Request $request){
        $validator = Validator::make($request->all(),[ 
            'amount' => 'required|int',
            'currency' => 'required|string',
            'card_number' => 'required|int',
            'name_on_card' => 'required|string'
        ]);
        if ($validator->fails())
            return response()->json([$validator->errors()->toJson()]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkout_session = Session::create([
            'customer' => $request->name_on_card ,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $request->currency,
                    'unit_amount' => $request->amount,
                ],
            ]],
            'mode' => 'payment',
            'success_url' =>' google.com',
            'cancel_url' => 'youtube.com',
        ]);
        $checkout = new Payment ();
        $checkout->name_on_card = $checkout_session->name_on_card;
        $checkout->amount = $checkout_session->amount;
        $checkout->currency =$checkout_session->currency;
        $checkout->card_number  = $checkout_session->card_number;
        $checkout->description = $checkout_session->description;
        $checkout->payer_email = '$request@gmail.com' ;
        $checkout->save();
        
        return response()->json([ 
            'message' => 'Thanks for your donate',
            'id' =>$checkout_session->id
        ]); 
    }
}