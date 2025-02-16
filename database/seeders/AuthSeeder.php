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

        $team = Team::create([
            'owner_id' => $teamAdmin->id,
            'name' => "Team Admin's Team",
            'is_active' => true
        ]);

        Permission::create(['name' => 'read:permissions', 'display_name' => 'Read Permissions']);
        Permission::create(['name' => 'write:permissions', 'display_name' => 'Write Permissions']);
        Permission::create(['name' => 'delete:permissions', 'display_name' => 'Delete Permissions']);

        Permission::create(['name' => 'read:roles', 'display_name' => 'Read Roles']);
        Permission::create(['name' => 'write:roles', 'display_name' => 'Write Roles']);
        Permission::create(['name' => 'delete:roles', 'display_name' => 'Delete Roles']);

        Permission::create(['name' => 'read:users', 'display_name' => 'Read Users']);
        Permission::create(['name' => 'write:users', 'display_name' => 'Write Users']);
        Permission::create(['name' => 'delete:users', 'display_name' => 'Delete Users']);

        Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
        ])->assignPermissions([
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

        Role::create([
            'team_id' => $team->id,
            'name' => 'team_admin',
            'display_name' => 'Team Admin',
        ])->assignPermissions([
            'read:permissions',
            'read:roles',
            'read:users',
            'write:users',
            'delete:users'
        ]);

        $admin->assignRole('admin');
        $teamAdmin->assignRole('team_admin');
    }
}
