<?php

namespace Tests\Feature\Api\V1\Tasks;

use App\Services\Auth\AuthServiceInterface;
use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends ApiV1TestCase
{
    use RefreshDatabase;

    private string $password;
    private string $email;

    private AuthServiceInterface $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiUrl .= '/login';

        $this->email = 'm3@gmail.com';
        $this->password = '12QWERTY3_q';

        $this->authService = app(AuthServiceInterface::class);
    }

    public function test_login_with_valid_data(): void
    {
        $this->authService->register([
            'name' => 'Test Name',
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password,
        ]);
        
        $this->postJson($this->apiUrl, [
            'password' => $this->password,
            'email' => $this->email,
        ])->assertSuccessful();
    }

    public function test_login_with_invalid_data(): void
    {
        $this->postJson($this->apiUrl, [
            'password' => $this->password,
            'email' => $this->email,
        ])->assertStatus(422);
    }
}