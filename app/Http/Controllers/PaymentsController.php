<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;

class PaymentsController extends Controller
{
    /**
     * Store a new payment.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'nombre' => 'required|string',
            'cantidad' => 'required|between:0,99999.99',
            'mes' => 'required|string',
        ]);

        try {

            $payment = new Payment;
            $payment->nombre = $request->input('nombre');
            $payment->cantidad = $request->input('cantidad');
            $payment->mes = $request->input('mes');

            $payment->save();

            //return successful response
            return response()->json(['payment' => $payment, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Payment Registration Failed!'], 409);
        }

    }
}
