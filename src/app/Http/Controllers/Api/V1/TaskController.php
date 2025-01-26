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

/**
 * @group Task management
 *
 * APIs for managing tasks
 */
class TaskController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['auth:sanctum'];
    }

    /**
     * Get a list of tasks.
     * 
     * @queryParam filter[status] string Filter tasks by status. Example: Completed
     * @queryParam filter[creator_id] string Filter tasks by creator ids. Example: 1,2,5
     * 
     * @apiResourceCollection App\Http\Resources\Tasks\TaskResource
     * @apiResourceModel App\Models\Task
     * 
     * @response 401 {"message": "Unauthenticated."}
     */
    public function index(GetTasksAction $action)
    {
        return new TaskCollection($action->execute());
    }

    /**
     * Create task.
     * 
     * @response 201 {"message": "Task successfully created."}
     * @response 401 {"message": "Unauthenticated."}
     * @response 500 {"message": "Task not created"} scenario="Server error"
     * 
     * @response 422 {
     *     "message": "Validation Failed",
     *      "errors": {
     *          "name": [
     *              "The name field is required."
     *          ]
     *      }
     * }
     */
    public function store(StoreTaskRequest $request, StoreTaskAction $action)
    {
        return $action->execute($request->validated())
            ? response()->json(['message' => 'Task successfully created'], 201)
            : response()->json(['message' => 'Task not created'], 500);
    }

    /**
     * Get a single task.
     * 
     * @apiResource App\Http\Resources\Tasks\TaskResource
     * @apiResourceModel App\Models\Task
     * 
     * @response 401 {"message": "Unauthenticated."}
     * @response 404 {"message": "Not Found Resource"}
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Update task.
     * 
     * @response 200 {"message": "Task successfully updated"}
     * @response 401 {"message": "Unauthenticated."}
     * @response 404 {"message": "Not Found Resource"}
     * @response 500 {"message": "Task not updated"} scenario="Server error"
     * 
     * @response 422 {
     *     "message": "Validation Failed",
     *      "errors": {
     *          "name": [
     *              "The name field is required."
     *          ]
     *      }
     * }
     */
    public function update(UpdateTaskRequest $request, Task $task, UpdateTaskAction $action)
    {
        return $action->execute($task, $request->validated())
            ? response()->json(['message' => 'Task successfully updated'], 200)
            : response()->json(['message' => 'Task not updated'], 500);
    }

    /**
     * Delete task.
     * 
     * @response 204 scenario=Success
     * @response 401 {"message": "Unauthenticated."}
     * @response 404 {"message": "Not Found Resource"}
     * @response 400 {"message": "Task not deleted"}
     */
    public function destroy(Task $task, DeleteTaskAction $action)
    {
        return $action->execute($task)
            ? response()->noContent()
            : response()->json(['message' => 'Task not deleted'], 400);
    }

    /**
     * Set the task status as completed.
     * 
     * @response 200 {"message": "Task completed"}
     * @response 401 {"message": "Unauthenticated."}
     * @response 404 {"message": "Not Found Resource"}
     * @response 400 {"message": "Task not completed"}
     */
    public function complete(Task $task, CompleteTaskAction $action)
    {
        return $action->execute($task)
            ? response()->json(['message' => 'Task completed'], 200)
            : response()->json(['message' => 'Task not completed'], 400);
    }

    /**
     * Set the task status as uncompleted.
     * 
     * @response 200 {"message": "Task uncompleted"}
     * @response 401 {"message": "Unauthenticated."}
     * @response 404 {"message": "Not Found Resource"}
     * @response 400 {"message": "Task not uncompleted"}
     */
    public function uncomplete(Task $task, UncompleteTaskAction $action)
    {
        return $action->execute($task)
            ? response()->json(['message' => 'Task uncompleted'], 200)
            : response()->json(['message' => 'Task not uncompleted'], 400);
    }
}
