<?php

namespace App\Notifications\Api;

use App\NotificationChannels\SmsRu\SmsRuChannel;
use App\NotificationChannels\SmsRu\SmsRuMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendCode extends Notification
{
    use Queueable;

    protected $code;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(int $code)
    {
        //
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail', SmsRuChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Your code for reset password:')
            ->line($this->code);
    }

    /**
     * @param $notifiable
     * @return SmsRuMessage
     */
    public function toSmsru($notifiable): SmsRuMessage
    {
        return (new SmsRuMessage())
            ->content($this->code)
            ->from(config('app.name'))
            ->test(config('services.sms.testing'))
            ->translit(config('services.sms.translit'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
