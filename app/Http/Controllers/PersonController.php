<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;

class PersonController extends Controller
{
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
}
