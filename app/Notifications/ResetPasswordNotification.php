<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        return (new MailMessage)
            ->subject('Redefinição de senha — falloutBurguer')
            ->greeting('Olá!')
            ->line('Você recebeu esse e-mail porque foi solicitado uma redefinição de senha na sua conta.')
            ->action('Redefinir senha', url('/'))
            ->line('Se preferir copie e cole o código para redefinir sua senha:' . $this->token)
            ->line('O link e o código de redefinição de senha irá expirar em 60 minutos')
            ->line('Se você não solicitou essa redefinição de senha, ignore este e-mail.');
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
