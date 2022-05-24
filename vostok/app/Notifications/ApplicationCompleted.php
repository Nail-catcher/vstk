<?php

namespace App\Notifications;

use App\Models\Application;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;

class ApplicationCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var User
     */
    private $user;
    /**
     * @var Application
     */
    private $application;

    /**
     * Create a new notification instance.
     *
     * @param Application $application
     * @param User $user
     */
    public function __construct(Application $application, User $user)
    {
        //
        $this->user = $user;
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
     * @param $notifiable
     * @return OneSignalMessage
     */
    public function toOneSignal($notifiable): OneSignalMessage
    {
        return OneSignalMessage::create()
            ->setSubject("Заявка №{$this->application->id} завершена.")
            ->setBody("Инженер {$this->user->firstname} {$this->user->lastname} закончил выполнение заявки №{$this->application->id}.");
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
