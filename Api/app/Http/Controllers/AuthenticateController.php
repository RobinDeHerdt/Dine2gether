<?php

namespace App\Http\Controllers;

use App\Mail\ActivateUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;

class AuthenticateController extends Controller
{
    /**
     * Authenticates users.
     *
     * @param  \Illuminate\Http\Request  $request
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

        // Return a JWT.
        return response()->json([
            'token' => $token
        ]);
    }

    /**
     * Registers users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $user = new User();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->city = $request->city;
        $user->password = bcrypt($request->password);
        $user->token = str_random(16);

        $user->save();

        Mail::to($user->email)->send(new ActivateUser($user));

        $token = JWTAuth::fromUser($user);

        // Return a JWT.
        return response()->json([
            'token' => $token
        ]);
    }
}
