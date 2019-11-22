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

    public function getCobro(Request $request, $id)
    {
        $this->validate($request, [
            'pago'     => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'efectivo' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'cambio'   => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'tipo_pago'=> 'required|string',
            'estado'=> 'required|numeric',
        ]);

        try {
            $dateToday = date("d/m/Y");
    
            $user = Person::where('USR_NUMCON', $id)->first();
            $currentCollector = Auth::user();
            $payment = new Payment();

            if($user != null){

                $pago = ($request->input('pago') == $user->USR_ADEUDO) 
                        ? 0 
                        : ($request->input('pago') > $user->USR_ADEUDO)
                        ? - ($request->input('pago') - $user->USR_ADEUDO)
                        : $user->USR_ADEUDO - $request->input('pago');
                
                $payment->numcon    = $user->USR_NUMCON; 
                $payment->nombre    = $user->USR_NOMBRE; 
                $payment->domici    = $user->USR_DOMICI; 
                $payment->zona      = $user->USR_ZONA; 
                $payment->ruta      = $user->USR_RUTA; 
                $payment->progr     = $user->USR_PROGR;
                $payment->cvetar    = $user->USR_CVETAR;
                $payment->fpago     = $dateToday;
                $payment->faviso    = $user->CTR_AVISO;
                $payment->saldoant  = $user->USR_ADEUDO;
                $payment->saldopost = $pago;
                $payment->iva       = $user->USR_IVA;
                $payment->total     = $user->USR_TOTAL;
                $payment->efectivo  = $request->input('efectivo');
                $payment->cambio    = $request->input('cambio');
                $payment->tipopago  = $request->input('tipo_pago');
                $payment->tusuario  = $currentCollector->name;
                $payment->tpc       = '';
                $payment->referencia= '';
                $payment->estado    = $request->input('tipo_pago');

                $user->USR_FECULTPAGO= $dateToday;
                $user->USR_ADEUDO    = $pago;
                $user->USR_FACTUR    = 0;
                $user->USR_IVA       = 0;
                $user->USR_SUBTOTAL  = 0;
                $user->USR_SUBSIDIO  = 0;
                $user->USR_TOTAL     = 0;
            }
    
            return response()->json(['current_collector' => $currentCollector, 'user' => $user, 'payments' => $payment], 200);
    
        } catch (\Exception $e) {
    
            return response()->json(['message' => 'user not found!'], 404);
        }
    
    }
}
