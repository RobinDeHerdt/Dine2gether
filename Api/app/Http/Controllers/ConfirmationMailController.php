<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Booking;
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

    public function sendBookingMails(Request $request) {
        $guest = User::where('id', $request->guest_id)->first();
        $host = User::where('id', $request->host_id)->first();
        $booking = Booking::where('id', $request->booking_id)->first();
        $date = $request->date;
        $time = $request->time; 

        $this->mailer->send('mails.guestmailbooking', ["username" => $guest->first_name, "host" => $host, "booking" => $booking, "date" => $date, "time" => $time], function (Message $m) use ($guest) {
                $m->to($guest->email)->from("info@d2g.com")->subject("Ready to make new friends?");
        });

        $this->mailer->send('mails.hostmailbooking', ["username" => $host->first_name, "guest" => $guest, "date" => $date, "time" => $time], function (Message $m) use ($host) {
                $m->to($host->email)->from("info@d2g.com")->subject("Ready to make new friends?");
        });
    }
}
