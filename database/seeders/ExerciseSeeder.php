<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categoriesWithExercises = [
            'Chest' => ['Bench Press', 'Push-Ups'],
            'Leg' => ['Squats', 'Lunges'],
            'Abs' => ['Sit-Ups', 'Plank'],
            'Back' => ['Pull-Ups', 'Deadlift'],
            'Shoulder' => ['Shoulder dumbell press', 'side raise'],
        ];

        $categories = DB::table('category')->whereIn('name', array_keys($categoriesWithExercises))->get();

        $now = now();

        foreach ($categories as $category) {
            foreach ($categoriesWithExercises[$category->name] as $exerciseName) {
                DB::table('exercise')->insertOrIgnore(
                    [
                        'name' => $exerciseName,
                        'category_id' => $category->id,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ] 
                );
            }
        }
    }
}
