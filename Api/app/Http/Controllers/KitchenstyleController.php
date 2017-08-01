<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Kitchenstyle;

class KitchenstyleController extends Controller
{
    /**
     * Fetch all kitchenstyles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kitchenstyles = Kitchenstyle::all();

        return response()->json([
            'kitchenstyles' => $kitchenstyles
        ]);
    }
}
