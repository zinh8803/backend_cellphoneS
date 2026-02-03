<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles
        $this->call(RoleSeeder::class);

        // Get roles
        $adminRole = \App\Models\Role::where('name', 'admin')->first();
        $userRole = \App\Models\Role::where('name', 'user')->first();

        // Create default admin
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role_id' => $adminRole ? $adminRole->id : null,
            'password' => bcrypt('admin123'),
        ]);

        // Create default user
        \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'role_id' => $userRole ? $userRole->id : null,
            'password' => bcrypt('user123'),
        ]);
    }
}
