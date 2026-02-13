<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Notifications\TaskCreatedNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request): TaskCollection
    {
        $tasks = Auth::user()->tasks()
            ->orderBy('created_at')
            ->paginate($request->get('per_page', 15));

        return new TaskCollection($tasks);
    }

    public function store(TaskRequest $request): JsonResponse
    {
        $task = Auth::user()->tasks()->create(
            $request->validated() + ['status' => $request->get('status', 'pending')]
        );

        Auth::user()->notify(new TaskCreatedNotification($task));
        
        return (new TaskResource($task))
            ->response()
            ->setStatusCode(201)
            ->header('Location', route('tasks.show', ['task' => $task->id]));
    }

    public function show($id): TaskResource
    {
        $task = Auth::user()->tasks()->findOrFail($id);
        
        return new TaskResource($task);
    }

    public function update(TaskRequest $request, $id): TaskResource
    {
        $task = Auth::user()->tasks()->findOrFail($id);
        $task->update($request->validated());

        return new TaskResource($task);
    }

    public function destroy($id): Response
    {
        $task = Auth::user()->tasks()->findOrFail($id);
        $task->delete();

        return response()->noContent();
    }
}