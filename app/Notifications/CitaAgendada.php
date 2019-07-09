<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class PushDemo extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    //es la notificacion para el admin se crea
    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title("Agenda Grid")
            ->body('Te han Agendado la Cita! Confirmala')
            ->icon('img/logo/Logo.jpg');            
            //->action('Aceptar', 'notification_action')
            //->badge('/img/logo/Logo.png')            
            // ->data(['id' => $notification->id])
            // ->badge()
            // ->dir()
            // ->image()
            // ->lang()
            // ->renotify()
            // ->requireInteraction()
            // ->tag()
            // ->vibrate()
    }
}
