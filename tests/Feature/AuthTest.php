<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
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


}
