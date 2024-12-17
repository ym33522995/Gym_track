<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->updateOrInsert(
            ['email' => 'Jim@gmail.com'],
            [
            'name' => "Jim",
            'password' => Hash::make("Jim"), 
            'email' => "Jim@gmail.com",
            'weight' => 80.5,
            'height' => 180.0,
            'age' => 21,
        ]);
    }
}
