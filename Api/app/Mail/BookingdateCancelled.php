<?php

namespace App\Mail;

use App\Bookingdate;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookingdateCancelled extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * User instance.
     *
     * @var \App\User  $user
     */
    public $user;

    /**
     * Host instance.
     *
     * @var \App\User  $host
     */
    public $host;

    /**
     * Date instance.
     *
     * @var Carbon $date
     */
    public $date;

    /**
     * Time instance.
     *
     * @var Carbon $time
     */
    public $time;

    /**
     * Booking instance.
     *
     * @var \App\Booking $booking
     */
    public $booking;

    /**
     * Create a new message instance.
     *
     * @param \App\User  $user
     * @param \App\User  $host
     * @param \App\Bookingdate  $bookingdate
     */
    public function __construct(User $user, User $host, Bookingdate $bookingdate)
    {
        $this->user = $user;
        $this->host = $host;
        $this->date = Carbon::parse($bookingdate->date)->format('l \\t\\h\\e jS \\of F');
        $this->time = Carbon::parse($bookingdate->date)->format('h:i A');
        $this->booking = $bookingdate->booking()->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@d2g.com')
            ->subject($this->host->first_name . ' has cancelled "' . $this->booking->title . '" on '. $this->date)
            ->view('emails.bookingdate-cancelled')
            ->with([
                'user' => $this->user,
                'host' => $this->host,
                'date' => $this->date,
                'time' => $this->time,
                'booking' => $this->booking
            ]);
    }
}
