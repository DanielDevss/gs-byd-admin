<?php

namespace App\Mail;

use App\Enum\ContactPreference;
use App\Enum\ContactType;
use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $title;
    public ContactType $type;
    public ?string $preheader;
    public string $name;
    public string $email;
    public string $phone;
    public ContactPreference $contactPreference;
    public ?string $textMessage;
    public ?Vehicle $vehicle;
    public string $locationName;
    private array $mailsCc = [];
    private array $mailsBcc = [];

    /**
     * Create a new message instance.
     */
    public function __construct(
        ContactType $type,
        string $name,
        string $email,
        string $phone,
        ?string $message = null,
        ?ContactPreference $contactPreference = ContactPreference::WHATSAPP,
        ?Vehicle $vehicle = null,
        string $locationName,
        array $cc = [],
        array $bcc = []
    ) {
        $this->type = $type;
        $this->title = $type->title();
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->contactPreference = $contactPreference;
        $this->textMessage = $message;
        $this->vehicle = $vehicle;
        $this->preheader = "{$this->name}, quiere ser contactado por {$this->contactPreference->value}.";
        $this->locationName = $locationName;
        $this->mailsCc = $cc;
        $this->mailsBcc = $bcc;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->type->subject() ?? "{$this->name}, envío un mensaje.",
            cc: $this->mailsCc,
            bcc: $this->mailsBcc
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.contact',
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
