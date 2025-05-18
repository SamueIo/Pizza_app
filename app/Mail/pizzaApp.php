<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;

class pizzaApp extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $cartData;

    // ✅ Pridáme parameter $cartData do konštruktora
    public function __construct($order, $cartData)
    {
        $this->order = $order;
        $this->cartData = $cartData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Potvrdenie objednávky'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-confirmation'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
