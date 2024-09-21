<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Brand 1'],
            ['name' => 'Brand 2'],
            ['name' => 'Brand 3'],
        ];
        DB::table('brands')->insert($brands);
    }
}
