<?php

namespace App\Mail\Client;

use App\Models\Contest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContestResultMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Contest $contest,
        public int $rank,
        public int $reward,
        public string $duration,
        public ?Carbon $startAt,
        public ?Carbon $endAt,
        public int $totalSteps,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('mail.contest_result.subject'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.contest-result',
        );
    }
}
