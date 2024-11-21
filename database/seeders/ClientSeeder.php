<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Client;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $advisorIds = User::where('role_id', Role::ADVISOR)->pluck('id')->toArray();

        for ($i = 0; $i < 100; $i++) {
            $insert[] = [
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'advisor_id' => $faker->randomElement($advisorIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Client::insert($insert);
    }
}
