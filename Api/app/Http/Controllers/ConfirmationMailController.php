<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;	

class ConfirmationMailController extends Controller
{

    public function __construct (Mailer $mailer) {
        $this->mailer = $mailer;
    }
    public function sendConfirmationRequestMail(Request $request) {

    	$guest = User::where('id', $request->user_id)->first();
    	$host = User::where('id', $request->host_id)->first();

        $link_booknow =  url('/#/booknow/') . "/" . $request->booking_id;
        $link_bookingdetails = url('/#/booking/') . "/" . $request->booking_id . "/details";

    	$this->mailer->send('mails.guest_confirmedrequestmail', ["username" => $guest->first_name, "hostname" => $host->first_name, "link_booknow" => $link_booknow, "link_bookingdetails" => $link_bookingdetails], function (Message $m) use ($guest) {
    			$m->to($guest->email)->from("info@d2g.com")->subject("Wonderful! You're request has been accepted");
    	});

        return response()->json(["status" => "success"]);

    }
}