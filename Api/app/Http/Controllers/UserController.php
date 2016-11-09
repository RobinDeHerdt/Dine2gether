<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use AppHttpControllersController;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use App\User;   
use Response;

class UserController extends Controller
{

    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth', ['except' => ['create']]);
    }

    public function index($id)
    {
        $user = User::find($id);

        return Response::json($user);
    }

    public function upload(Request $request)
    {
        $user = User::find($request->user_id);

        $path = $request->file->store('img/profile', 'upload');
        
        $user->image  = $path;

        $user->save();

        return response()->json(['filename' => $path]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Store happens in RegisterController
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name'    => 'required|max:255|regex:/(^[A-Za-z0-9 -]+$)+/',
            'last_name'     => 'required|max:255|regex:/(^[A-Za-z0-9 -]+$)+/',
            'email'         => 'required|email|max:255',
        ]);

        $user = User::find($id);

        $user->first_name           = $request->first_name;
        $user->last_name            = $request->last_name;
        $user->email                = $request->email;
        $user->street_number        = $request->street_number;
        $user->postalcode           = $request->postalcode;
        $user->city                 = $request->city;

        $user->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
