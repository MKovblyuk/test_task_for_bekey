<?php

namespace Tests\Feature\Api\V1\Tasks;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Support\Str;

class UpdateTaskTest extends ApiV1TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $task = Task::factory()->create(['creator_id' => $this->user->id]);
        $this->apiUrl .= "/tasks/{$task->id}";
    }

    public function test_put_updating_tasks_without_authentication(): void
    {
        $this->putJson($this->apiUrl)->assertStatus(401);
    }

    public function test_put_updating_tasks_by_authenticated_user(): void
    {
        $data = [
            'name' => 'Name',
            'description' => 'Desc',
        ];

        $this->actingAs($this->user)->putJson($this->apiUrl,data: $data)->assertSuccessful();
    }

    public function test_put_updating_tasks_without_full_data(): void
    {
        $data = ['name' => 'Some'];
        $this->actingAs($this->user)->putJson($this->apiUrl, $data)->assertStatus(422);

        $data = ['description' => 'Some'];
        $this->actingAs($this->user)->putJson($this->apiUrl, $data)->assertStatus(422);
    }


    public function test_put_updating_tasks_with_invalid_data(): void
    {
        $data = [
            'name' => Str::random(101),
            'description' => Str::random(256),
            'status' => 'Not Valid Value',
        ];

        $this->actingAs($this->user)->putJson($this->apiUrl, $data)->assertStatus(422);
    }

    public function test_put_updating_tasks_with_empty_data(): void
    {
        $this->actingAs($this->user)->putJson($this->apiUrl)->assertStatus(422);
    }

    public function test_patch_updating_tasks_without_authentication(): void
    {
        $this->patchJson($this->apiUrl)->assertStatus(401);
    }

    public function test_patch_updating_tasks_by_authenticated_user(): void
    {
        $data = [
            'name' => 'Name',
            'description' => 'Desc',
        ];

        $this->actingAs($this->user)->patchJson($this->apiUrl,data: $data)->assertSuccessful();
    }

    public function test_patch_updating_tasks_without_full_data(): void
    {
        $data = ['name' => 'Some'];
        $this->actingAs($this->user)->patchJson($this->apiUrl, $data)->assertSuccessful();

        $data = ['description' => 'Some'];
        $this->actingAs($this->user)->patchJson($this->apiUrl, $data)->assertSuccessful();
    }


    public function test_patch_updating_tasks_with_invalid_data(): void
    {
        $data = [
            'name' => Str::random(101),
            'description' => Str::random(256),
            'status' => 'Not Valid Value',
        ];

        $this->actingAs($this->user)->patchJson($this->apiUrl, $data)->assertStatus(422);
    }

    public function test_patch_updating_tasks_with_empty_data(): void
    {
        $this->actingAs($this->user)->patchJson($this->apiUrl)->assertSuccessful();
    }
}