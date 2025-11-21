<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $fleets;
    public $isAdmin;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking, $fleets = [], $isAdmin = false)
    {
        $this->booking = $booking;
        $this->fleets = $fleets;
        $this->isAdmin = $isAdmin;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = $this->isAdmin 
            ? 'New Booking Received - #' . $this->booking->id
            : 'Booking Confirmation - #' . $this->booking->id;

        return $this->subject($subject)
                    ->view('emails.booking-confirmation')
                    ->with([
                        'booking' => $this->booking,
                        'fleets' => $this->fleets,
                        'isAdmin' => $this->isAdmin,
                    ]);
    }
}

