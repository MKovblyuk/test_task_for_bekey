<?php

namespace Tests\Feature\Api\V1\Tasks;

use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends ApiV1TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiUrl .= '/logout';
    }

    public function test_logout_without_authentication(): void
    {
        $this->postJson($this->apiUrl)->assertStatus(401);
    }

    public function test_logout(): void
    {
        $this->actingAs($this->user)->postJson($this->apiUrl)->assertSuccessful();
    }
}