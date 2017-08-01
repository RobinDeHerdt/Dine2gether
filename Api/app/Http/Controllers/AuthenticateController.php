<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use AppHttpControllersController;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use App\User;

class AuthenticateController extends Controller
{
    /**
     * Constructor.
     *
     * Apply the jwt.auth middleware to all methods in this controller
     * except for the authenticate method. We don't want to prevent
     * the user from retrieving their token if they don't already have it
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', [
            'except' => [
                'login',
                'register'
            ]]);
    }

    /**
     * Logs in users.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|max:255|email',
            'password'  => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        try {
            // Verify the credentials and create a token for the user.
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'invalid_credentials'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'could_not_create_token'
            ], 500);
        }

        // If no errors are encountered, return a JWT.
        return response()->json([
            'token' => $token
        ]);
    }

    /**
     * Get the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        }

        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * Registers users.
     *
     * @return \App\User
     */
    public function register(Request $request)
    {
        $user = $request->all();

        $password = bcrypt($request->input('password'));
        $newuser['password'] = $password;

        return User::create($user);
    }
}
