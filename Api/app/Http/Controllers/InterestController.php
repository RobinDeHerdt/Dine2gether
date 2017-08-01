<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Interest;

class InterestController extends Controller
{
    /**
     * Fetch all interests.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interests = Interest::all();

        return response()->json([
            'interests' => $interests
        ]);
    }
}
