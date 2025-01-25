<?php

namespace App\Actions\Tasks;

use App\Models\Task;

class StoreTaskAction
{
    public function execute(array $attributes): bool
    {
        try {
            Task::create($attributes);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}