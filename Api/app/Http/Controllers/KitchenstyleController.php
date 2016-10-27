<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Kitchenstyle;

class KitchenstyleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kitchenstyles = Kitchenstyle::all();
        return response()->json(["kitchenstyles" => $kitchenstyles]);
    }
}
