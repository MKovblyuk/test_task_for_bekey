<?php

namespace Tests\Feature\Api\V1\Tasks;

use App\Models\Task;
use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTaskTest extends ApiV1TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiUrl .= '/tasks/';
    }

    public function test_deleting_tasks_without_authentication(): void
    {
        $task = Task::factory()->create(['creator_id' => $this->user->id]);

        $this->delete(
            uri: $this->apiUrl . $task->id, 
            headers: $this->baseHeaders
        )->assertStatus(401);
    }

    public function test_deleting_tasks_by_authenticated_user(): void
    {
        $task = Task::factory()->create(['creator_id' => $this->user->id]);

        $this->actingAs($this->user)->delete(
            uri: $this->apiUrl . $task->id, 
            headers: $this->baseHeaders
        )->assertNoContent();
    }

    public function test_deleting_tasks_non_existent_task(): void
    {
        $this->actingAs($this->user)->delete(
            uri: $this->apiUrl . 1, 
            headers: $this->baseHeaders
        )->assertNotFound();
    }
}