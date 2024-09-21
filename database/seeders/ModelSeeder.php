<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            [
                'brand_id' => 1,
                'name' => 'Модель 1',
                'cat_id' => 1,
                'price' => 99.99
            ],
            [
                'brand_id' => 2,
                'name' => 'Модель 2',
                'cat_id' => 2,
                'price' => 149.99
            ],
        ];
        DB::table('models')->insert($models);
    }
}
