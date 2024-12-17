<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class RecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $now = now();
        $user = DB::table('users')->where('email', 'Jim@gmail.com')->first();

        DB::table('record')->insertOrIgnore(
            [
                'date' => $now,
                'user_id' => $user->id,
                'created_at' => $now,
                'updated_at' => $now,
            ] 
        );
    }
}
