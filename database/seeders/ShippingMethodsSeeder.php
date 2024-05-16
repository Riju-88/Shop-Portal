<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ShippingMethod;

class ShippingMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         // Number of shipping methods
         $numberOfShippingMethods = 5;

         // Use the factory to create shipping methods
         ShippingMethod::factory()->count($numberOfShippingMethods)->create();
    }
}
