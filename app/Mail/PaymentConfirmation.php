<?php

namespace App\Mail;

use App\Models\Invoice;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $booking;
    public $isAdmin;

    /**
     * Create a new message instance.
     */
    public function __construct(Invoice $invoice, Booking $booking = null, $isAdmin = false)
    {
        $this->invoice = $invoice;
        $this->booking = $booking;
        $this->isAdmin = $isAdmin;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = $this->isAdmin 
            ? 'Payment Received - Invoice #' . $this->invoice->invoice_number
            : 'Payment Confirmation - Invoice #' . $this->invoice->invoice_number;

        return $this->subject($subject)
                    ->view('emails.payment-confirmation')
                    ->with([
                        'invoice' => $this->invoice,
                        'booking' => $this->booking,
                        'isAdmin' => $this->isAdmin,
                    ]);
    }
}

