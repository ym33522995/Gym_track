<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = DB::table('users')->where('email', 'Jim@gmail.com')->first();

        if ($user) {
            DB::table('templates')->insertOrIgnore([
                'name' => "push",
                'user_id' => $user->id, 
            ]);
        }
    }
}
