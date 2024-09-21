<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = [
            [
                'product_id' => 1,
                'user_id' => 2,
                'order_date' => now(),
                'delivery_date' => now()->addDays(5),
                'quantity_product' => 2,
                'status_id' => 1,
                'cost' => 249.98,
                'processing_type_id' => 1,
            ],
            [
                'product_id' => 2,
                'user_id' => 2,
                'order_date' => now(),
                'delivery_date' => now()->addDays(7),
                'quantity_product' => 1,
                'status_id' => 2,
                'cost' => 374.98,
                'processing_type_id' => 2,
            ]
        ];
        DB::table('orders')->insert($orders);
    }
}
