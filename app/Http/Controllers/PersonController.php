<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Person;
use App\Payment;

class PersonController extends Controller
{
    /**
     * Instantiate a new PersonController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.role:ADMIN,COLLECTOR', ['only' => ['allPersons', 'getCobro']]);
    }
    /**
     * Get all Persons.
     *
     * @return Response
     */
    public function allPersons(Request $request)
    {

        $allUsers = Person::query();

        if($request->has('contract')){
            $allUsers = $allUsers->where('USR_NUMCON', 'LIKE', '%' . trim($request->input('contract')) . '%');
        }

        if($request->has('name')){
            $allUsers = $allUsers->where('USR_NOMBRE', 'LIKE', '%' . trim($request->input('name')) . '%');
        }

        if(!$request->has('contract') && !$request->has('name')){
            return response()->json(['usuarios' =>  Person::all()->take(15)], 200);
        }

        $allUsers = $allUsers->get();
        
        return response()->json(['usuarios' =>  $allUsers], 200);
    }

    public function getCobro($id)
    {
        try {
            $dateToday = date("d/m/Y");
    
            $user = Person::where('USR_NUMCON', $id)->first();
            $currentCollector = Auth::user();
            $payment = new Payment();

            if($user != null){
                $user->USR_FECULTPAGO;
                $user->USR_ADEUDO;
                $user->USR_FACTUR;
                $user->USR_IVA;
                $user->USR_SUBTOTAL;
                $user->USR_SUBSIDIO;
                $user->USR_TOTAL;
                
                
                $payment->numcon    = $user->USR_NUMCON; 
                $payment->nombre    = $user->USR_NOMBRE; 
                $payment->domici    = $user->USR_DOMICI; 
                $payment->zona      = $user->USR_ZONA; 
                $payment->ruta      = $user->USR_RUTA; 
                $payment->progr     = $user->USR_PROGR;
                $payment->cvetar    = $user->USR_CVETAR;
                $payment->fpago     = '';
                $payment->faviso    = $user->CTR_AVISO;
                $payment->saldoant  = '';
                $payment->saldopost = '';
                $payment->iva       = $user->USR_IVA;
                $payment->total     = $user->USR_TOTAL;
                $payment->efectivo  = '';
                $payment->cambio    = '';
                $payment->tipopago  = '';
                $payment->tusuario  = $currentCollector->name;
                $payment->tpc       = '';
                $payment->referencia= '';
                $payment->estado    = '';
            }
    
            return response()->json(['current_collector' => $currentCollector, 'user' => $user, 'payments' => $payment], 200);
    
        } catch (\Exception $e) {
    
            return response()->json(['message' => 'user not found!'], 404);
        }
    
    }
}
