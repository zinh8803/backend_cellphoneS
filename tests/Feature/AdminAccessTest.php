<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::query()->create(['id' => 1, 'name' => 'admin']);
        Role::query()->create(['id' => 2, 'name' => 'user']);
    }

    public function test_non_admin_cannot_access_user_list_endpoint(): void
    {
        $user = User::factory()->create([
            'email' => 'member@example.com',
            'password' => bcrypt('password123'),
            'role_id' => 2,
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/auth/users');

        $response->assertStatus(403)
            ->assertJsonPath('status', 403)
            ->assertJsonPath('message', 'Forbidden');
    }

    public function test_admin_can_access_user_list_endpoint(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role_id' => 1,
        ]);

        $token = JWTAuth::fromUser($admin);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/auth/users');

        $response->assertStatus(200)
            ->assertJsonPath('status', 200)
            ->assertJsonStructure(['status', 'message', 'data', 'errors']);
    }
}
