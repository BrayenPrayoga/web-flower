<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AktivasiLogin extends Mailable
{
    use Queueable, SerializesModels;

     /**
     * The demo object instance.
     *
     * @var Aktivasi
     */
    public $aktivasi;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($aktivasi)
    {
        //
        $this->aktivasi = $aktivasi;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from(
            $this->aktivasi->senderEmail,
            $this->aktivasi->senderName,
            $this->aktivasi->id_users)
            ->subject($this->aktivasi->subject)->to($this->aktivasi->email)->markdown('email.aktivasi')->with([
            'message' => $this->aktivasi->message,
            'sender' => $this->aktivasi->senderName,
            'subject' => $this->aktivasi->subject,
        ]);     
    }
}
