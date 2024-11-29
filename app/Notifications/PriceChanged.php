<?php

namespace App\Notifications;

use App\Models\Advert;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PriceChanged extends Notification
{
    use Queueable;

    private Advert $advert;

    /**
     * Create a new notification instance.
     */
    public function __construct($advert)
    {
        $this->advert = $advert;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = $this->advert->url;
        $previousPrice = $this->advert->previous_price;
        $price = $this->advert->price;
        $updatedAt = $this->advert->updated_at;

        return (new MailMessage)
                    ->line('The price change notification.')
                    ->line("Price for $url has changed from $previousPrice to $price on $updatedAt.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
