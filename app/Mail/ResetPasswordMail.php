<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ResetPasswordMail extends Mailable
{
    // Sengaja TIDAK pakai Queueable trait — agar selalu sync/langsung terkirim

    public string $resetUrl;
    public string $userName;

    public function __construct(string $resetUrl, string $userName)
    {
        $this->resetUrl = $resetUrl;
        $this->userName = $userName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Reset Password – UndanganKu');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.reset-password');
    }
}
