<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DataUpdated extends Notification implements ShouldQueue
{
    use Queueable;


    private $video;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($video)
    {
        $this->video = $video;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {   
        $url = url('/video/'.$this->video->id);

        return (new MailMessage)
                    ->subject('Summary Generated')
                    ->greeting('Hello!')
                    ->line('Data for the video titled "'. $this->video->title .'" you uploaded is now ready.')
                    ->action('View Now', $url)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'data' => 'Data for the video titled "'. $this->video->title .'" you uploaded is now ready.'
        ];
    }
    
    public function viaQueues()
    {
        return [
            'mail' => 'mail-queue',
            'database' => 'database-queue',
        ];
    }
}
