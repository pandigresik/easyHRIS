<?php

namespace App\Notifications;

use App\Models\AlertMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class AlertNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(AlertMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $url = url('/invoice/' . $this->invoice->id);

        return TelegramMessage::create()
            ->to($this->message->getUserId()) // Optional.
            ->content($this->message->getContent()) // Markdown supported.
            ;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
