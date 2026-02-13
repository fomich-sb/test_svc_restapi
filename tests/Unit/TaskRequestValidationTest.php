<?php

namespace Tests\Unit;

use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class TaskRequestValidationTest extends TestCase
{
    private TaskRequest $request;
    private array $rules;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new TaskRequest();
        $this->rules = $this->request->rules();
    }

    public function test_valid_data_passes_validation()
    {
        $data = [
            'title' => 'Тестовая задача',
            'description' => 'Описание задачи',
            'status' => 'pending',
            'due_date' => now()->addDays(3)->format('Y-m-d'),
        ];
        
        $validator = Validator::make($data, $this->rules);
        $this->assertTrue($validator->passes());
    }

    public function test_minimal_data_passes_validation()
    {
        $data = [
            'title' => 'Минимальная задача',
        ];
        
        $validator = Validator::make($data, $this->rules);
        $this->assertTrue($validator->passes());
    }

    public function test_missing_title_fails_validation()
    {
        $data = [
            'description' => 'Описание без заголовка',
        ];
        
        $validator = Validator::make($data, $this->rules);
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('title', $validator->errors()->toArray());
    }

    public function test_invalid_status_fails_validation()
    {
        $data = [
            'title' => 'Задача',
            'status' => 'invalid_status',
        ];
        
        $validator = Validator::make($data, $this->rules);
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('status', $validator->errors()->toArray());
    }
}