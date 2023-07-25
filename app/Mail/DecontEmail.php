<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DecontEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $maildata = [];
    /**
     * Create a new message instance.
     */
    public function __construct($maildata) {
        $this->maildata = $maildata;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Decont Email',
        );
    }


    // return new Envelope(
    //     from: new Address('jeffrey@example.com', 'Jeffrey Way'),
    //     replyTo: [
    //         new Address('taylor@example.com', 'Taylor Otwell'),
    //     ],
    //     subject: 'Order Shipped',
    // );

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.decont2',
            with: [
                'maildata' => $this->maildata,
                'url' => 'https://expand.ro',
            ],
        );
    }


    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
