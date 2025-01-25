<?php

namespace App\Actions\Tasks;

use App\Models\Task;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetTasksAction
{
    public function execute(int $perPage = null): Collection
    {
        $query = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('creator_id'),
                'status',
            ]);

        return $perPage ? $query->paginate($perPage) : $query->get();
    }
}

