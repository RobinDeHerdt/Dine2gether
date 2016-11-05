<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ActivationService;

class activationMailController extends Controller
{
	public function __construct (ActivationService $activationService) {
		$this->activationService = $activationService;
	}

    public function sendActivationMail (Request $request) {

    	$this->activationService->sendActivationMail($request);
    	$info = "We hebben je een mail gestuurd om je account te activeren. Neem eens een kijkje.";

    	return response()->json(["info" => $info]);
    }
}
