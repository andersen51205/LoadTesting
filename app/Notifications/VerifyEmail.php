<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class VerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($authCode)
    {
        $this->authCode = $authCode;
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
        $verifyCode = $this->authCode;
        return (new MailMessage)
                    ->greeting($notifiable->name.' 您好：')
                    ->subject('性能測試平台註冊認證信，您的驗證碼為'.$verifyCode)
                    ->line('歡迎使用性能測試平台，')
                    ->line('您的驗證碼為 '.$verifyCode.' ，')
                    ->line('有效時間為三十分鐘')
                    ->line('若驗證碼失效請至平台重新發送認證信。');
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
