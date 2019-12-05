<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use  App\User;
use App\Collect;

class UserController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('auth.role:ADMIN,COLLECTOR', ['only' => ['getCollects']]);
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */
    public function profile()
    {
        return response()->json(['user' => Auth::user()], 201);
    }

    /**
     * Get all User.
     *
     * @return Response
     */
    public function allUsers()
    {   
        error_log('allUsers');

         return response()->json(['users' =>  User::all()], 200);
    }

    /**
     * Get one user.
     *
     * @return Response
     */
    public function getUser($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json(['user' => $user], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'user not found!'], 404);
        }

    }

    public function getCollects()
    {
        $currentCollector = Auth::user();
        $dateToday = date("Y-m-d");
        $total = 0;
        //error_log($dateToday);
        //$from = date('2019-11-30');
        //$collects = User::find($currentCollector->id)->collects()->get();
        $collects = User::find($currentCollector->id)
        ->collects()
        ->whereBetween('created_at', [$dateToday." 00:00:00", $dateToday." 23:59:59"])
        ->get();

        foreach ($collects as $collect) {
            $collect->location = json_decode($collect->location);
            $collect->data = json_decode($collect->data);
            $total += $collect->data->pago;
        }

        return response()->json(['today_collects' => $collects, 'total' => $total], 200);
    }

}