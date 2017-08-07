<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivateUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * User instance.
     *
     * @var \App\User  $user
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param \App\User  $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@d2g.com')
            ->subject('Welcome to Dine2gether!')
            ->view('emails.activation')
            ->with([
                'user' => $this->user,
            ]);
    }
}
