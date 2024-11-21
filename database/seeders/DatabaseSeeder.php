<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Client;
use App\Models\CashLoanProduct;
use App\Models\HomeLoanProduct;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // NOTE: mandatory seeder.
        $this->call(RoleSeeder::class);

        // if statement has been added to check if there are records in the tables
        // how it wouldn't seed the DB several times with duplicates.

        if (in_array(env('APP_ENV'), ['local', 'testing'])) {
            // Advisors for testing.
            if (User::where('role_id', Role::ADVISOR)->doesntExist()) {
                $this->call(AdvisorSeeder::class);
            }

            // Default user for testing.
            if (User::where('email', 'test@example.com')->doesntExist()) {
                User::factory()->create([
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                ]);
            }

            // Clients for testing.
            if (Client::doesntExist()) {
                $this->call(ClientSeeder::class);
            }

            // Home loan products for testing.
            if (HomeLoanProduct::doesntExist()) {
                $this->call(HomeLoanProductSeeder::class);
            }

            // Cash loan products for testing.
            if (CashLoanProduct::doesntExist()) {
                $this->call(CashLoanProductSeeder::class);
            }
        }
    }
}
