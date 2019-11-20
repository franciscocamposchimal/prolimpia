<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'token_created_at' => date("d/m/Y h:i:s"),
            'expires_in' => Auth::factory()->getTTL() * 720
        ], 200);
    }
}
