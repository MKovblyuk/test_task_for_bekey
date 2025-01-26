<?php

namespace Tests\Feature\Api\V1\Tasks;

use App\Models\Task;
use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompleteTaskTest extends ApiV1TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $task = Task::factory()->create(['creator_id' => $this->user->id]);
        $this->apiUrl .= "/tasks/{$task->id}/complete";
    }

    public function test_completing_tasks_without_authentication(): void
    {
        $this->patchJson($this->apiUrl)->assertStatus(401);
    }

    public function test_completing_tasks_by_authenticated_user(): void
    {
        $this->actingAs($this->user)->patchJson($this->apiUrl)->assertSuccessful();
    }

    public function test_completing_non_existent_task(): void
    {
        Task::query()->delete();
        $this->actingAs($this->user)->patchJson($this->apiUrl)->assertNotFound();
    }
}