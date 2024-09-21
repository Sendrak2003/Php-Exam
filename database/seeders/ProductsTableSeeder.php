<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'model_id' => 1,
                'serialNumber' => 'XYZ123',
                'yearOfRelease' => '2023-02-01',
                'name' => 'Товар 1'
            ],
            [
                'model_id' => 2,
                'serialNumber' => 'UVW456',
                'yearOfRelease' => '2022-09-15',
                'name' => 'Товар 2'
            ]
        ];

        DB::table('products')->insert($products);
    }
}
