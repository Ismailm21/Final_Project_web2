<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Order::Create([
           'client_id' => 2,
           'driver_id' => 5,
           'pickup_address_id' => 1,
           'dropoff_address_id' => 3,
           'package_weight' => 10.0,
           'package_size_l' => 12,
           'package_size_w' => 12,
           'package_size_h' => 12,
           'delivery_date' => '2025-05-15',
           'status' => 'Processing',
           'tracking_code' => 10,


       ]);
    }
}
