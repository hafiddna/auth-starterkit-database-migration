<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use function Symfony\Component\Translation\t;

class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'is_active' => true
        ]);

        UserProfile::factory()->create([
            'user_id' => $admin->id,
            'full_name' => 'Admin',
            'nick_name' => 'Admin'
        ]);

        $teamAdmin = User::factory()->create([
            'email' => 'team_admin@example.com',
            'is_active' => true
        ]);

        UserProfile::factory()->create([
            'user_id' => $teamAdmin->id,
            'full_name' => 'Team Admin',
            'nick_name' => 'Team Admin'
        ]);

        Team::create([
            'owner_id' => $teamAdmin->id,
            'name' => "Team Admin's Team",
            'is_active' => true
        ]);

        Permission::create(['name' => 'read:permissions']);
        Permission::create(['name' => 'write:permissions']);
        Permission::create(['name' => 'delete:permissions']);

        Permission::create(['name' => 'read:roles']);
        Permission::create(['name' => 'write:roles']);
        Permission::create(['name' => 'delete:roles']);

        Permission::create(['name' => 'read:users']);
        Permission::create(['name' => 'write:users']);
        Permission::create(['name' => 'delete:users']);

        Role::create(['name' => 'admin'])->assignPermissions([
            'read:permissions',
            'write:permissions',
            'delete:permissions',
            'read:roles',
            'write:roles',
            'delete:roles',
            'read:users',
            'write:users',
            'delete:users'
        ]);

        $admin->assignRole('admin');
        $teamAdmin->assignRole('admin');
    }
}
