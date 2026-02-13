<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskOverdueNotification extends Notification
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
            ->subject('Задача просрочена')
            ->greeting('Здравствуйте, ' . $notifiable->name . '!')
            ->line('Задача "' . $this->task->title . '" не была завершена в срок.')
            ->line('Срок выполнения был: ' . $this->task->due_date->format('d.m.Y'))
            ->line('Текущий статус: ' . $this->task->status);
    }
}