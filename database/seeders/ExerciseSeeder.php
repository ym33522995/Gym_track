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
            'Chest' => [
                'Bench Press', 'Push-Ups', 'Pec Fly', 'Incline Bench Press', 'Decline Bench Press',
                'Chest Dips', 'Cable Crossover', 'Dumbbell Fly', 'Machine Chest Press', 'Clapping Push-Ups', 'Dumbbell Chest Press',
            ],
            'Leg' => [
                'Squats', 'Lunges', 'Leg Press', 'Step-Ups', 'Bulgarian Split Squat', 'Sissy squat',
                'Hack Squat', 'Calf Raises', 'Jump Squats', 'Pistol Squats', 'Wall Sit', 'Leg extension', 'Leg Curl', 'Abduction', 'Adduction'
            ],
            'Abs' => [
                'Sit-Ups', 'Plank', 'Hanging Leg Raises', 'Russian Twists', 'Bicycle Crunches',
                'Toe Touches', 'Ab Rollout', 'Cable Crunch', 'V-Ups', 'Mountain Climbers'
            ],
            'Back' => [
                'Pull-Ups', 'Deadlift', 'Bent-Over Rows', 'Lat Pulldown', 'T-Bar Row', 'Wide Lat Pulldown',
                'Single Arm Dumbbell Row', 'Seated Cable Row', 'Face Pulls', 'Good Mornings', 'Reverse Fly'
            ],
            'Shoulder' => [
                'Shoulder Dumbbell Press', 'Side Raise', 'Front Raise', 'Overhead Press', 'Arnold Press',
                'Lateral Raises', 'Upright Rows', 'Face Pulls', 'Reverse Pec Deck', 'Cable Lateral Raise', 'Military Press'
            ],
            'Biceps' => [
                'Barbell Curl', 'Dumbbell Curl', 'Hammer Curl', 'Concentration Curl', 'Preacher Curl', 'Incline Dumbbell Curl',
                'EZ Bar Curl', 'Cable Curl', 'Reverse Curl', 'Drag Curl', 'Zottman Curl'
            ],
            'Triceps' => [
                'Tricep Dips', 'Close-Grip Bench Press', 'Overhead Tricep Extension', 'Skull Crushers', 'Diamond Push-Ups',
                'Rope Tricep Pushdown', 'Dumbbell Kickbacks', 'French Press', 'Bodyweight Triceps Extension', 'Machine Tricep Dip'
            ],
            'Forearm' => [
                'Wrist Curls', 'Reverse Wrist Curls', 'Farmer’s Walk', 'Towel Grip Pull-Ups', 'Finger Curls',
                'Plate Pinch Hold', 'Dead Hangs', 'Hammer Curl', 'Reverse Barbell Curl', 'Rope Climbing'
            ],
            'Full body' => [
                'Burpees', 'Kettlebell Swings', 'Clean and Press', 'Snatch', 'Deadlifts',
                'Thrusters', 'Battle Ropes', 'Medicine Ball Slams', 'Sled Push', 'Jump Rope'
            ],
        ];
        

        $categories = DB::table('categories')->whereIn('name', array_keys($categoriesWithExercises))->get();

        $now = now();

        foreach ($categories as $category) {
            foreach ($categoriesWithExercises[$category->name] as $exerciseName) {
                DB::table('exercises')->insertOrIgnore(
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
