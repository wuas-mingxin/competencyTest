<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Umair',
                'email' => 'Umair@gmail.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        \App\Models\User::insert($data);
    }
}
