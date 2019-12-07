<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\User;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    /**
     * Instantiate a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.role:ADMIN,COLLECTOR', ['only' => ['check']]);
    }
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'rol' => 'required|string',
        ]);

        try {

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->rol = $request->input('rol');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }

    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
    */
    public function login(Request $request)
    {
          //validate incoming request 
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token, Auth::user());
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function check()
    {
        return response()->json(Auth::user(),200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        //Auth::logout();
        try 
        {
            config([
            'jwt.blacklist_enabled' => true
            ]);
            //\Cookie::forget(JWTAuth::parseToken());
            //Auth::guard()->logout();
            Auth::logout();
            \Auth::logout(true);
            \Auth::invalidate();
            Auth::invalidate();

            $token = JWTAuth::getToken();
            JWTAuth::setToken($token)->invalidate(true);
            JWTAuth::invalidate();
            JWTAuth::invalidate(true);
            JWTAuth::invalidate(JWTAuth::getToken());
            JWTAuth::invalidate(JWTAuth::parseToken());
            JWTAuth::parseToken()->invalidate();

            return response()->json(['message' => 'Successfully logged out']);
            
        } 
        catch (Exception $e) 
        {
            return response()->json(['message' => 'There is something wrong try again']);
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

}