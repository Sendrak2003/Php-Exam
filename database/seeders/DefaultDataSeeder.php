<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DefaultDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Категегория 1'],
            ['name' => 'Категегория 2'],
            ['name' => 'Категегория 3'],

        ];
        // Вставка категорий в таблицу 'categories'
        DB::table('categories')->insert($categories);

        $processingTypes = [
            ['name' => 'Chrome plating','price' => 50.00],
            ['name' => 'Nickel plating','price' => 75.00],
            ['name' => 'Gilding','price' => 100.00],
        ];

        DB::table('processing_types')->insert($processingTypes);

        $statuses = [null,'Принято', 'Завершено', 'Отправлено', 'В процессе'];
        foreach ($statuses as $status) {
            DB::table('statuses')->insert([
                'name' => $status,
            ]);
        }

        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'user'],
        ]);

    }
}
