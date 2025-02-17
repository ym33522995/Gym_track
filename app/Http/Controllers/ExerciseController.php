<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Exercise $exercise)
    {
        //
        return view('gym_track.exercise')->with(['exercises' => $exercise->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
        $category = $request->input('category');

        if ($category) {
            $exercises = Exercise::where('category', $category)->get();
        } else {
            $exercise = Exercise::all();
        }

        return view('gym_track.exercise', compact('exercises'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getAllExercises()
    {
        // Fetch exercises along with their category names
        $exercises = DB::table('exercises')
            ->join('categories', 'exercises.category_id', '=', 'categories.id')
            ->select('exercises.id', 'exercises.name as exercise_name', 'categories.name as category_name')
            ->get();

        Log::info('Fetched all exercises:', [
            'success' => true,
            'exercises' => $exercises,
        ]);

        return response()->json([
            'success' => true,
            'exercises' => $exercises,
        ]);
    }


}
