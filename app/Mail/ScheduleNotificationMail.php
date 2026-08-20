<?php

namespace App\Mail;

use App\Models\ClassSchedule;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ScheduleNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public ClassSchedule $schedule;
    public string $participantName;
    public string $siteName;

    /**
     * Create a new message instance.
     */
    public function __construct(ClassSchedule $schedule, string $participantName, string $siteName = 'LPK MPI')
    {
        $this->schedule        = $schedule;
        $this->participantName = $participantName;
        $this->siteName        = $siteName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $programTitle = $this->schedule->trainingProgram?->title ?? $this->schedule->topic;
        return new Envelope(
            subject: '📅 Undangan Jadwal Pelatihan — ' . $programTitle . ' | ' . $this->siteName,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.schedule-notification',
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
