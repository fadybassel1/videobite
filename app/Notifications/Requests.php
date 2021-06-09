<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\models\Video;
use App\User;

class Requests extends Notification implements ShouldQueue
{
    use Queueable;


    private $video;
    private $text;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($video,$text)
    {
        $this->video = Video::find($video);;
        $this->text = $text;
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
        $user = User::find($this->video->user_id);

        if ($this->text == "new") {
            return (new MailMessage)
                    ->subject('New Summary Request')
                    ->greeting('Hello!')
                    ->line($user->name.'('.$user->email.')' . ' requested a new summary edit for the video titled "'. $this->video->title .'".')
                    ->action('View Now', $url);
        } else {
            return (new MailMessage)
                    ->subject('Summary Request '. $this->text)
                    ->greeting('Hello!')
                    ->line('Request to edit the summary for video titled "'. $this->video->title .'" is '. $this->text.'.')
                    ->action('View Now', $url)
                    ->line('Thank you for using our application!');
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $user = User::find($this->video->user_id);
        if ($this->text == "new") {
            return [
                'data' => $user->name.'('.$user->email.')' . ' requested a new summary edit for the video titled "'. $this->video->title . '".'
            ];
        } else {
            return [
                'data' => 'Request to edit the summary for video titled "'. $this->video->title .'" is '. $this->text .'.'
            ];
        }
    }
    
    public function viaQueues()
    {
        return [
            'mail' => 'mail-queue',
            'database' => 'database-queue',
        ];
    }
}
