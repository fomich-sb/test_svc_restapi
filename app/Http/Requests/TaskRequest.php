<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['sometimes', Rule::in(['pending', 'in_progress', 'completed'])],
            'due_date' => 'nullable|date_format:Y-m-d', //|after_or_equal:today
        ];

        if ($this->isMethod('POST')) {
            $rules['status'] = ['sometimes', Rule::in(['pending', 'in_progress', 'completed'])];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Название задачи обязательно',
            'title.max' => 'Название не может быть длиннее 255 символов',
            'status.in' => 'Статус должен быть: pending, in_progress, или completed',
            'due_date.date_format' => 'Дата должна быть в формате Y-m-d',
        ];
    }
}