<?php

namespace App\Observers;

use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskObserver
{
    public function updating(Task $task): void
    {
        if ($task->getOriginal('due_date') != $task->due_date && !$task->isOverdue() && $task->overdue_notified_at !== null) {
            $task->resetOverdueNotification();
        }
    }
}