<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $user;
    public $expires_in;

    /**
     * Create a new message instance.
     */
    public function __construct($token, $user, $expires_in)
    {
        $this->token = $token;
        $this->user = $user;
        $this->expires_in = $expires_in;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Activate Your Account',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'auth.emails.activation',
            with: [
                'activation_url' => route('activate', ['token' => $this->token, 'email' => $this->user->email]),
                'expires_in' => $this->expires_in,
                'year' => date('Y'),
            ],
        );
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
