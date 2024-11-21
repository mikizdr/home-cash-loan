<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Client;
use App\Models\HomeLoanProduct;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HomeLoanProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientsIds = Client::pluck('id')->toArray();
        $min = 1000000;
        $max = 5000000;

        $homeLoanProducts = [];
        shuffle($clientsIds);
        $chunk = rand(20, 30);
        foreach ($clientsIds as $key => $clientId) {
            if ($key === $chunk) {
                break;
            }
            $propertyValue = round(rand($min, $max), 3);
            $downPayment = $propertyValue * 0.2;
            $homeLoanProducts[] = [
                'client_id' => $clientId,
                'property_value' => $propertyValue,
                'down_payment' => $downPayment,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        HomeLoanProduct::insert($homeLoanProducts);
    }
}
