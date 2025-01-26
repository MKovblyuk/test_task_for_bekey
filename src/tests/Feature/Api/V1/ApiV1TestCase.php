<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use Tests\TestCase;

class ApiV1TestCase extends TestCase
{
    protected string $apiUrl = 'api/v1';
    protected array $baseHeaders;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->baseHeaders = [
            'Accept' => 'application/json',
        ];
    }
}
