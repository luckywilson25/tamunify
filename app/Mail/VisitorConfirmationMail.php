<?php

namespace App\Mail;

use App\Models\Visitor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class VisitorConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $visitor;

    /**
     * Create a new message instance.
     */
    public function __construct($visitor)
    {
        $this->visitor = $visitor;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Konfirmasi',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if ($this->visitor->type->value == 'Tamu Umum') {
            return new Content(
                view: 'email.visitor.confirmation.one-time',
                with: [
                    'visitor' => $this->visitor,
                ]
            );
        } else if ($this->visitor->type->value == 'Magang') {
            return new Content(
                view: 'email.visitor.confirmation.internship',
                with: [
                    'visitor' => $this->visitor,
                ]
            );
        } else {
            return new Content(
                view: 'email.visitor.confirmation.recurring',
                with: [
                    'visitor' => $this->visitor,
                ]
            );
        }
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}