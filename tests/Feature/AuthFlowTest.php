<?php

namespace Tests\Feature;

use App\Models\RefreshToken;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::query()->create(['id' => 1, 'name' => 'admin']);
        Role::query()->create(['id' => 2, 'name' => 'user']);
    }

    public function test_user_can_login_and_receive_refresh_token(): void
    {
        User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
            'role_id' => 2,
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.refreshToken', fn($value) => is_string($value) && strlen($value) >= 40)
            ->assertJsonPath('data.roleId', 2)
            ->assertCookie('token');
    }

    public function test_refresh_token_is_rotated_on_refresh(): void
    {
        User::factory()->create([
            'email' => 'refresh@example.com',
            'password' => bcrypt('password123'),
            'role_id' => 2,
        ]);

        $loginResponse = $this->postJson('/api/auth/login', [
            'email' => 'refresh@example.com',
            'password' => 'password123',
        ]);

        $refreshToken = $loginResponse->json('data.refreshToken');

        $refreshResponse = $this->postJson('/api/auth/refresh-token', [
            'refresh_token' => $refreshToken,
        ]);

        $refreshResponse->assertStatus(200)
            ->assertJsonPath('data.refreshToken', fn($value) => is_string($value) && $value !== $refreshToken)
            ->assertCookie('token');

        $this->assertSame(1, RefreshToken::query()->count());
    }

    public function test_logout_revokes_provided_refresh_token(): void
    {
        $user = User::factory()->create([
            'email' => 'logout@example.com',
            'password' => bcrypt('password123'),
            'role_id' => 2,
        ]);

        $loginResponse = $this->postJson('/api/auth/login', [
            'email' => 'logout@example.com',
            'password' => 'password123',
        ]);

        $refreshToken = $loginResponse->json('data.refreshToken');
        $jwtToken = JWTAuth::fromUser($user);

        $logoutResponse = $this->withHeader('Authorization', 'Bearer ' . $jwtToken)
            ->postJson('/api/auth/logout', [
                'refresh_token' => $refreshToken,
            ]);

        $logoutResponse->assertStatus(200)
            ->assertJsonPath('message', 'Logged out successfully');

        $this->assertSame(0, RefreshToken::query()->count());
    }
}
