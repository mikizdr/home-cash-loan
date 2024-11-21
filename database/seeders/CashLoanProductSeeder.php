<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Client;
use App\Models\CashLoanProduct;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CashLoanProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientsIds = Client::pluck('id')->toArray();
        $min = 100000;
        $max = 1000000;

        $cashLoanProducts = [];
        shuffle($clientsIds);
        $chunk = rand(20, 30);
        foreach ($clientsIds as $key => $clientId) {
            if ($key === $chunk) {
                break;
            }
            $propertyValue = rand($min, $max);
            $cashLoanProducts[] = [
                'client_id' => $clientId,
                'loan_amount' => $propertyValue,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        CashLoanProduct::insert($cashLoanProducts);
    }
}
