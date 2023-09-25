<?php

namespace App\Notifications;

use App\User;
use App\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BooksNotification extends Notification
{
    use Queueable;

    public $sendNotify;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sendNotify)
    {
        $this->sendNotify = $sendNotify;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');
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
            'booking_id' => $this->sendNotify['id'],
            'customer_name' => $this->sendNotify['name'],
            'booking_no' => $this->sendNotify['booking_no'],
            'booking_date' => $this->sendNotify['booking_date'],
          
        ];

    }
}
