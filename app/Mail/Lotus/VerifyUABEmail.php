<?php

namespace App\Mail\Lotus;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyUABEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $signedVerifyURL;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $signedVerifyURL)
    {
        $this->signedVerifyURL = $signedVerifyURL;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Lotus Under the Lights: Verify your UAB E-Mail',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'mail.lotus.verify',
            with: [
                'signedVerifyURL' => $this->signedVerifyURL,
            ]
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
