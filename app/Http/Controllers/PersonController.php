<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Person;
use App\Payment;
use App\Collect;
use App\User;

class PersonController extends Controller
{
    /**
     * Instantiate a new PersonController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.role:ADMIN,COLLECTOR', ['only' => ['allPersons', 'getCobro', 'getCollects']]);
    }
    /**
     * Get all Persons.
     *
     * @return Response
     */
    public function allPersons(Request $request)
    {

        $allUsers = Person::query();

        if($request->has('q')){
        $allUsers = $allUsers->where('USR_NUMCON', 'LIKE', '%' . trim($request->input('q')) . '%')
        ->orWhere('USR_NOMBRE', 'LIKE', '%' . trim($request->input('q')) . '%')->take(15)->get();
        }

        if(!$request->has('q')){
            return response()->json(Person::all()->take(15), 200);
        }

        foreach ($allUsers as $user) {
            $num_length = strlen((string)$user->USR_NUMCON);
            if($num_length <= 5){
                $user->USR_NUMCON = str_pad($user->USR_NUMCON, 6, '0', STR_PAD_LEFT);
            };
        }
        
        return response()->json($allUsers, 200);
    }

    public function getOnePerson($id){
        $historialCobros = Payment::where('numcon', $id)->get();
        foreach ($historialCobros as $cobro) {
            $num_length = strlen((string)$cobro->numcon);
            if($num_length <= 5){
                $cobro->numcon = str_pad($cobro->numcon, 6, '0', STR_PAD_LEFT);
            };
        }
        return response()->json($historialCobros, 200);
    }

    public function getCobro(Request $request, $id)
    {
        $this->validate($request, [
            'pago'     => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'efectivo' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'cambio'   => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'tipo_pago'=> 'required|string',
            'mac'=> 'required|string'
        ]);

        try {
            $dateToday = date("d/m/Y");
            $user = Person::where('USR_NUMCON', $id)->first();
            $currentCollector = Auth::user();
            $payment = new Payment();
            $collect = new Collect();

            if($user != null){

                $pago = ($request->input('pago') == $user->USR_TOTAL) 
                        ? 0 
                        : ($request->input('pago') > $user->USR_TOTAL)
                        ? - ($request->input('pago') - $user->USR_TOTAL)
                        : $user->USR_TOTAL - $request->input('pago');
                //ticket
                $payment->numcon    = $user->USR_NUMCON; 
                $payment->nombre    = $user->USR_NOMBRE; 
                $payment->domici    = $user->USR_DOMICI; 
                $payment->zona      = $user->USR_ZONA; 
                $payment->ruta      = $user->USR_RUTA; 
                $payment->progr     = $user->USR_PROGR;
                $payment->cvetar    = $user->USR_CVETAR;
                $payment->fpago     = $dateToday;
                $payment->faviso    = $user->CTR_AVISO?? "";
                $payment->saldoant  = $user->USR_TOTAL;
                $payment->saldopost = $pago;
                $payment->iva       = $user->USR_IVA;
                $payment->total     = $request->input('pago');
                $payment->efectivo  = $request->input('efectivo');
                $payment->cambio    = $request->input('cambio');
                $payment->tipopago  = $request->input('tipo_pago');//efectivo, tarjeta, cheque
                $payment->tusuario  = $currentCollector->name;
                $payment->tpc       = $request->input('mac');//mac del cel
                $payment->referencia= $currentCollector->reference;//iniciales del que cobra
                $payment->estado    = 1;

                //usuarios
                // pagos adelentados solo si esta en ceros, si es anual se regala un mes
                $user->USR_FECULTPAGO= $dateToday;
                $user->USR_ADEUDO    = $user->USR_ADEUDO - $request->input('pago');// resto adeudo - abono , subtotal - abono y total - abono
                $user->USR_SUBTOTAL  = $user->USR_SUBTOTAL - $request->input('pago');// resto adeudo - abono , subtotal - abono y total - abono
                $user->USR_TOTAL     = $user->USR_TOTAL - $request->input('pago');// resto adeudo - abono , subtotal - abono y total - abono
            
                $collect->user_id = $currentCollector->id;
                $collect->contract = $user->USR_NUMCON;
                $collect->location = json_encode($request->input('location'));
                $collect->data = json_encode([
                    'nombre'        =>$user->USR_NOMBRE,
                    'zona'          =>$user->USR_ZONA,
                    'ruta'          =>$user->USR_RUTA,
                    'saldo_anterior'=> $user->USR_TOTAL,
                    'pago'          =>$request->input('pago'),
                    'efectivo'      =>$request->input('efectivo'),
                    'cambio'        =>$request->input('cambio'),
                    'tipo_pago'     =>$request->input('tipo_pago'),
                    'mac'           =>$request->input('mac')
                ]);

                //$payment->save();
                //$user->save();
                $collect->save();
            }
    
            return response()->json(['current_collector' => $currentCollector, 'user' => $user, 'collect' => $collect], 200);
    
        } catch (\Exception $e) {
            error_log($e);
            return response()->json(['message' => 'user not found!'], 404);
        }
    
    }
}
