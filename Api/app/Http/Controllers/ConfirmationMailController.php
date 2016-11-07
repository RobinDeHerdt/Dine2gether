<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;	

class ConfirmationMailController extends Controller
{
    public function sendConfirmationMails(Request $request) {

    	$guest = User::where('id', $request->user_id)->first();
    	$host = User::where('id', $request->host_id)->first();

    	Mailer::send('mails.confirmationguest', ["username" => $guest->first_name, "host" => $host], function (Message $m) use ($guest) {
    			$m->to($guest->email)->from("info@d2g.com")->subject("You're request has been accepted!");
    	})

    }
}
