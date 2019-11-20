<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;

class PersonController extends Controller
{
    /**
     * Instantiate a new PersonController instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth.role:ADMIN,COLLECTOR', ['only' => ['allPersons']]);
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
    
            return response()->json(['user' => $user], 200);
    
        } catch (\Exception $e) {
    
            return response()->json(['message' => 'user not found!'], 404);
        }
    
    }
}
