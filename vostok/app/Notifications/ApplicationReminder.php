<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;

class ApplicationReminder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Application
     */
    private $application;

    /**
     * Create a new notification instance.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [OneSignalChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * @param $notifiable
     * @return OneSignalMessage
     */
    public function toOneSignal($notifiable): OneSignalMessage
    {
        $text = '';
        switch ($this->application->attempts) {
            case 1:
                $text = "Повторное напоминание о не принятой заявка №{$this->application->id}.";
                break;
            case 2:
                $text = "Последнее напоминание о не принятой заявке №{$this->application->id}.";
                break;
            default:
                $text = "Напоминание о не принятой заявке №{$this->application->id}.";
        }
        return OneSignalMessage::create()
            ->setSubject("Напоминание о заявке №{$this->application->id}.")
            ->setBody($text);
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
