<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

/**
 * Seeding the database with advisors for testing.
 */
class AdvisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $advisors = [
            [
                'name' => 'Advisor One',
                'email' => 'a_one@example.com',
            ],
            [
                'name' => 'Advisor Two',
                'email' => 'a_two@example.com',
            ],
            [
                'name' => 'Advisor Three',
                'email' => 'a_three@example.com',
            ],
        ];

        $insert = [];
        $roleId = Role::ADVISOR;
        $password = Hash::make('password');

        foreach ($advisors as $advisor) {
            $insert[] = array_merge($advisor, [
                'password' => $password,
                'role_id' => $roleId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        User::insert($insert);
    }
}
