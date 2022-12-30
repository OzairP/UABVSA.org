<?php

namespace App\Mail\Lotus;

use App\Models\LotusReservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendReservationTicket extends Mailable
{

    use Queueable, SerializesModels;

    /**
     * @var \App\Models\LotusReservation
     */
    public LotusReservation $reservation;

    /**
     * Create a new message instance.
     * @return void
     */
    public function __construct (LotusReservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the message envelope.
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope ()
    {
        return new Envelope(
            to: $this->reservation->email,
            subject: 'Your Lotus Under the Lights Ticket' . ($this->reservation->tickets > 1 ? 's' : '')
        );
    }

    /**
     * Get the message content definition.
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content ()
    {
        return new Content(markdown: 'mail.lotus.ticket', with: [
            'reservation' => $this->reservation,
        ]);
    }


    /**
     * Get the attachments for the message.
     * @return array
     */
    public function attachments ()
    {
        return [
            Attachment::fromData(fn() => $this->reservation->generatePDF()->output(),
                'Lotus Under the Lights Ticket.pdf',
            )->withMime('application/pdf'),
        ];
    }
}
