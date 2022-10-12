<?php

namespace App\Notifications;

use App\Models\otpCode;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class emailNotification extends Notification
{
    use Queueable;
    private $user, $otp;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, otpCode $otp)
    {
        return [
            $this->user = $user,
            $this->otp = $otp
        ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from('amirul@rentcar.com', 'RentCar')
                    ->subject('Verification code')
                    ->line('To complete your RentCar verification, please use the following code :')
                    ->lineIf(true, "{$this->otp->otp}")
                    ->line('The code is valid for 30 minutes and can be used only once. If this request was not made by you, please ignore this email')
                    ->line('This message was sent automatically, please do not reply.');
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
