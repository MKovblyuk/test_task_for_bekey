<?php

namespace App\Actions\Tasks;

use App\Models\Task;

class UpdateTaskAction
{
    public function execute(Task $task, array $attributes): bool
    {
        return $task->update($attributes);
    }
}

