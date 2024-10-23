<?php

namespace Tests\Unit;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Mockery;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    use RefreshDatabase;

    public function test_register_with_valid_data(): void
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'user test',
            'email' => 'email@order.com',
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'response' => [
                    "status",
                    "data"=>[
                        'name',
                        'email',
                        'token',
                    ]
                ],
            ]);
    }
    public function test_register_with_missing_name(): void
    {
        $response = $this->postJson('/api/v1/register', [
            'email' => 'email@order.com',
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'response' => [
                    "status" => "FAILED",
                    "message"=>"The name field is required."
                ],
            ]);
    }

    public function test_register_with_duplicated_email(): void
    {
        $this->addUser();
        $response = $this->postJson('/api/v1/register', [
            'name' => 'user test',
            'email' => 'email@order.com',
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'response' => [
                    "status" => "FAILED",
                    "message"=>"The email has already been taken."
                ],
            ]);
    }

    public function test_login_with_valid_data(): void
    {
        $this->addUser();
        $response = $this->postJson('/api/v1/login', [
            'email' => 'email@order.com',
            'password' => '123456',
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'response' => [
                    "status",
                    "data"=>[
                        'name',
                        'email',
                        'token',
                    ]
                ],
            ]);
    }
    public function test_login_with_invalid_data(): void
    {
        $this->addUser();
        $response = $this->postJson('/api/v1/login', [
            'email' => 'wrongemail@order.com',
            'password' => '123456',
        ]);
        $response->assertStatus(200)
            ->assertJson([
                'response' => [
                    "status" => "FAILED",
                    "message"=>"Invalid credentials"
                ],
            ]);
    }


}
