<?php

namespace App\Actions\Tasks;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class StoreTaskAction
{
    public function execute(array $attributes): Task
    {         
        $attributes['creator_id'] = Auth::id();
        return Task::create($attributes); 
    }
}