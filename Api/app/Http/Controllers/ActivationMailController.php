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
    	$info = "We've sent you an email to activate your account. Please check your mailbox.";

    	return response()->json(["info" => $info]);
    }

    public function resendActivationMail (Request $request) {
    	$this->activationService->resendActivationMail($request);
    	$info = "We've resent you an email to activate your account. Please check your mailbox.";

    	return response()->json(["info" => $info]);
    }
}
