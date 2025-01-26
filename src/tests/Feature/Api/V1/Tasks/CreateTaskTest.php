<?php

namespace Tests\Feature\Api\V1\Tasks;

use App\Models\Task;
use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class CreateTaskTest extends ApiV1TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiUrl .= '/tasks';
    }

    public function test_creating_tasks_whithout_authentication(): void
    {
        $this->postJson($this->apiUrl)->assertStatus(401);
    }

    public function test_creating_tasks_by_authenticated_user(): void
    {
        $this->actingAs($this->user)->postJson(
            uri: $this->apiUrl,
            data: Task::factory()->make()->toArray()
        )->assertCreated();
    }

    public function test_creating_tasks_without_full_data(): void
    {
        $data = ['name' => 'Some'];
        $this->actingAs($this->user)->postJson($this->apiUrl, $data)->assertStatus(422);

        $data = ['description' => 'Some'];
        $this->actingAs($this->user)->postJson($this->apiUrl, $data)->assertStatus(422);
    }


    public function test_creating_tasks_with_invalid_data(): void
    {
        $data = [
            'name' => Str::random(101),
            'description' => Str::random(256),
        ];

        $this->actingAs($this->user)->postJson($this->apiUrl, $data)->assertStatus(422);
    }

    public function test_creating_tasks_with_empty_data(): void
    {
        $this->actingAs($this->user)->postJson($this->apiUrl)->assertStatus(422);
    }
}