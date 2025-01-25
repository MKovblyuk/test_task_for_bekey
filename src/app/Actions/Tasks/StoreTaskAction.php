<?php

namespace App\Actions\Tasks;

use App\Models\Task;

class StoreTaskAction
{
    public function execute(array $attributes): Task
    {         
        return Task::create($attributes); 
    }
}