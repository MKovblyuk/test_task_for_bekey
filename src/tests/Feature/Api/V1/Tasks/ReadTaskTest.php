<?php

namespace Tests\Feature\Api\V1\Tasks;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\V1\ApiV1TestCase;

class ReadTaskTest extends ApiV1TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiUrl .= '/tasks';
    }

    public function test_reading_tasks_without_authentication(): void
    {
        $this->getJson($this->apiUrl)->assertStatus(401);
    }

    public function test_reading_tasks_by_authenticated_user(): void
    {
        $tasksCount = 3;
        Task::factory($tasksCount)->create(['creator_id' => $this->user->id]);

        $this->actingAs($this->user)->getJson($this->apiUrl)
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'status',
                        'creatorId',
                        'createdAt',
                        'updatedAt',
                    ],
                ],
            ])->assertJsonCount($tasksCount, 'data');
    }

    public function test_reading_single_task(): void
    {
        $task = Task::factory()->create(['creator_id' => $this->user->id]);
        $this->actingAs($this->user)->getJson($this->apiUrl . "/{$task->id}")
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'status',
                    'creatorId',
                    'createdAt',
                    'updatedAt',
                ],
            ]);
    }

    public function test_reading_non_existent_task(): void
    {
        Task::query()->delete();
        $this->actingAs($this->user)->getJson($this->apiUrl . '/1')->assertNotFound();
    }

    /// todo
    // public function test_reading_tasks_with_status_filter(): void
    // {
    //     $completedTasksCount = 4;
    //     $uncompletedTasksCount = 6;

    //     Task::factory($completedTasksCount)->create([
    //         'creator_id' => $this->user->id,
    //         'status' => TaskStatus::Completed
    //     ]);
    //     Task::factory($uncompletedTasksCount)->create([
    //         'creator_id' => $this->user->id,
    //         'status' => TaskStatus::Uncompleted
    //     ]);

    //     $this->actingAs($this->user)->getJson($this->apiUrl . '?filter[status]=completed')
    //         ->assertSuccessful()
    //         ->assertJsonCount($completedTasksCount, 'data');

    //     // $this->actingAs($this->user)->getJson($this->apiUrl . '?filter[status]=uncompleted')
    //     //     ->assertSuccessful()
    //     //     ->assertJsonCount(1, 'data');
    // }

    // public function test_reading_tasks_with_creator_filter(): void
    // {

    // }
}