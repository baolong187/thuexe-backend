<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    public $bill;
    public $car;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details, $bill, $car)
    {
        //
        $this->details = $details;
        $this->bill = $bill;
        $this->car = $car;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Hóa đơn thuê xe')->view('emails.billMail');
    }
}
