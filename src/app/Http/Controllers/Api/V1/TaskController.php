<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Tasks\CompleteTaskAction;
use App\Actions\Tasks\DeleteTaskAction;
use App\Actions\Tasks\GetTasksAction;
use App\Actions\Tasks\StoreTaskAction;
use App\Actions\Tasks\UncompleteTaskAction;
use App\Actions\Tasks\UpdateTaskAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Http\Resources\Tasks\TaskCollection;
use App\Http\Resources\Tasks\TaskResource;
use App\Models\Task;
use Illuminate\Routing\Controllers\HasMiddleware;

class TaskController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['auth:sanctum'];
    }

    public function index(GetTasksAction $action)
    {
        return new TaskCollection($action->execute());
    }

    public function store(StoreTaskRequest $request, StoreTaskAction $action)
    {
        return $action->execute($request->validated())
            ? response()->json(['message' => 'Task successfully created'], 201)
            : response()->json(['message' => 'Task not created'], 500);
    }

    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, Task $task, UpdateTaskAction $action)
    {
        return $action->execute($task, $request->validated())
            ? response()->json(['message' => 'Task successfully updated'], 200)
            : response()->json(['message' => 'Task not updated'], 500);
    }

    public function destroy(Task $task, DeleteTaskAction $action)
    {
        return $action->execute($task)
            ? response()->noContent()
            : response()->json(['message' => 'Task not deleted'], 400);
    }

    public function complete(Task $task, CompleteTaskAction $action)
    {
        return $action->execute($task)
            ? response()->json(['message' => 'Task completed'], 200)
            : response()->json(['message' => 'Task not completed'], 400);
    }

    public function uncomplete(Task $task, UncompleteTaskAction $action)
    {
        return $action->execute($task)
            ? response()->json(['message' => 'Task uncompleted'], 200)
            : response()->json(['message' => 'Task not uncompleted'], 400);
    }
}
