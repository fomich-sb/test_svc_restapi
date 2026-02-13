<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskOverdueNotification;
use Illuminate\Console\Command;

class CheckOverdueTasks extends Command
{
    protected $signature = 'tasks:check-overdue';
    protected $description = 'Проверка просроченных задач и отправка уведомлений';

    public function handle(): int
    {
        $overdueTasks = Task::overdueNotNotified()
            ->with('user')
            ->get();

        $count = $overdueTasks->count();
        $this->info("Найдено просроченных задач: {$count}");

        foreach ($overdueTasks as $task) {
            try {
                $task->user->notify(new TaskOverdueNotification($task));
                
                $task->markAsOverdueNotified();
                $this->line("Уведомление отправлено для задачи {$task->id}");
            } catch (\Exception $e) {
                $this->error("Ошибка для задачи {$task->id}: {$e->getMessage()}");
            }
        }
        
        $this->info('Рассылка завершена!');
        
        return Command::SUCCESS;
    }
}