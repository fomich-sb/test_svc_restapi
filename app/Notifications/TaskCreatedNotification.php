<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(public Task $task)
    {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Новая задача создана')
            ->greeting('Здравствуйте, ' . $notifiable->name . '!')
            ->line('Ваша задача "' . $this->task->title . '" успешно создана.')
            ->line('Статус: ' . $this->task->status)
            ->when($this->task->due_date, function ($mail) {
                return $mail->line('Срок выполнения: ' . $this->task->due_date->format('d.m.Y'));
            });
    }
}