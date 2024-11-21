<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

/**
 * Mandatory seeder for users' roles.
 */
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = array_map(function ($role): array {
            return ['name' => $role];
        }, array_keys(Role::ROLES));

        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }
    }
}
