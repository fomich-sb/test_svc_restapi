<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskOverdueNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TaskOverdueTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test-token')->plainTextToken;
        Notification::fake();
    }

    public function test_overdue_notification()
    {
        // Создаем задачу с датой на сегодня
        $task = Task::factory()->for($this->user)->create([
            'due_date' => now(),
            'status' => 'pending',
            'overdue_notified_at' => null,
        ]);

        // следующий день
        $this->travel(1)->day();

        $this->artisan('tasks:check-overdue')->assertExitCode(0);
        Notification::assertSentTo($this->user, TaskOverdueNotification::class);
        $this->assertNotNull($task->fresh()->overdue_notified_at);
    }
}