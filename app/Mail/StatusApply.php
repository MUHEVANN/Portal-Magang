<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusApply extends Mailable
{
    use Queueable, SerializesModels;
    private $status;
    /**
     * Create a new message instance.
     */
    public function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hasil Pendaftaran',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $template_seleksi = '';
        if($this->status == 'lulus'){
            $template_seleksi = 'Mail.lulusSeleksi';
        } else{
            $template_seleksi = 'Mail.gagalSeleksi';
        }

        return new Content(
            markdown: $template_seleksi,
            with: ['status' => $this->status]
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
