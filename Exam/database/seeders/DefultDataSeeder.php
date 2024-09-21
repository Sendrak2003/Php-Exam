<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DefultDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'firstname' =>'Admin',
            'lastname' => 'One',
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('Qwerty_123'),
            'is_admin' => true,
        ]);

        DB::table('users')->insert([
            'firstname' =>'User',
            'lastname' => 'One',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('Qwerty_123'),
            'is_admin' => false,
        ]);
        DB::table('tasks')->insert([
            [
                'title' => 'Task_1',
                'start_date' => '2021-01-01',
                'end_date' => '2021-01-05',
                'status' => false,
                'user_id' => 2,
            ],
            [
                'title' => 'Task_2',
                'start_date' => '2021-02-01',
                'end_date' => '2021-02-05',
                'status' => false,
                'user_id' => 2,
            ],
        ]);

    }
}
