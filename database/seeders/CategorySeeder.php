<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = [
            'Chest', 'Back', 'Leg', 'Shoulder', 'Biceps', 'Triceps', 'Abs', 'Forearm', 'Full body'
        ];
        
        $now = now();

        foreach($categories as $category) {
            DB::table('categories')->insertOrIgnore(
                [
                    'name' => $category,
                    'created_at' => $now, 
                    'updated_at' => $now,
                ]
            );
        }
    }
}
