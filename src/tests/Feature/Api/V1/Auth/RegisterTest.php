<?php

namespace Tests\Feature\Api\V1\Tasks;

use App\Models\User;
use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends ApiV1TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiUrl .= '/register';
    }

    public function test_register_with_valid_data(): void
    {
        $data = [
            'name' => 'some_name',
            'email' => 'm2@gmail.com',
            'password' => '12QWERTY3_q',
            'password_confirmation' => '12QWERTY3_q'
        ];

        $this->postJson($this->apiUrl, $data)->assertSuccessful();
    }

    public function test_register_with_weak_password(): void
    {
        $data = [
            'name' => 'some_name',
            'email' => 'm2@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ];

        $this->postJson($this->apiUrl, $data)->assertStatus(422);
    }

    public function test_register_with_existed_email(): void
    {
        $email = 'm2@gmail.com';
        User::factory()->create(['email' => $email]);

        $data = [
            'name' => 'some_name',
            'email' => $email,
            'password' => '12QWERTY3_q',
            'password_confirmation' => '12QWERTY3_q'
        ];

        $this->postJson($this->apiUrl, $data)->assertStatus(422);
    }

    public function test_register_invalid_confirmation_password(): void
    {
        $data = [
            'name' => 'some_name',
            'email' => 'm2@gmail.com',
            'password' => '12QWERTY3_q_1',
            'password_confirmation' => '12QWERTY3_q_2'
        ];
        
        $this->postJson($this->apiUrl, $data)->assertStatus(422);
    }
}