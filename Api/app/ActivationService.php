<?php

namespace App;

use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class ActivationService
{
    protected $mailer;
    protected $activationRepo;
    protected $resendAfter = 24;

    public function __construct (Mailer $mailer, ActivationRepository $activationRepo) {
    	$this->mailer = $mailer;
    	$this->activationRepo = $activationRepo;
    }

    public function sendActivationMail($user)
    {
        if ($user->activated /*|| !$this->shouldSend($user)*/) {
            return;
        }

        $token = $this->activationRepo->createActivation($user);

        $link = url('/#/activation/') . "/" .$token;
        $message = sprintf('Activate account <a href="%s">%s</a>', $link, $link);

        $this->mailer->send('mails.activationmail',['username' => $user->first_name, 'link' => $link], function 
            (Message $m) use ($user) {
                $m->to($user->email)->from("info@d2g.com")->subject('Welcome to Dine2gether!');

        });
        /*$this->mailer->raw($message, function (Message $m) use ($user) {
            $m->to($user->email)->subject('Welcome to Dine2gether!');
        });*/
    }

    public function activateUser($token)
    {
        $activation = $this->activationRepo->getActivationByToken($token);

        if ($activation === null) {
            return null;
        }

        $user = User::find($activation->user_id);
        $user->activated = true;
        $user->save();
        //$this->activationRepo->deleteActivation($token);

        return $user;
    }

    private function shouldSend($user)
    {
        $activation = $this->activationRepo->getActivation($user);
        return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
    }
}
