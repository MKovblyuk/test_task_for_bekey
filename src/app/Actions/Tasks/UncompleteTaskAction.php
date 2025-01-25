<?php

namespace App\Actions\Tasks;

use App\Enums\TaskStatus;
use App\Models\Task;

class UncompleteTaskAction
{
    public function execute(Task $task): bool
    {
        return $task->update(['status' => TaskStatus::Uncompleted]);
    }
}