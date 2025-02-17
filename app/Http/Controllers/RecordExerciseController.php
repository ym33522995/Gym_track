<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RecordExercise;
use Illuminate\Support\Facades\Log;

class RecordExerciseController extends Controller
{
    //
    public function saveNotes(Request $request, $exerciseId)
    {
        $request->validate([
            'set_number' => 'required|integer',
            'notes' => 'required|string',
        ]);

        $recordExercise = RecordExercise::where('exercise_id', $exerciseId)
            ->first();

        if ($recordExercise) {
            $recordExercise->notes = $request->input('notes');
            $recordExercise->save();

            return response()->json(['success' => true, 'message' => 'Notes saved successfully.', 'notes' => $recordExercise->notes]);
        }

        return response()->json(['success' => false, 'message' => 'Record not found.']);
    }

    public function getNotes(Request $request, $exerciseId)
    {
        // $request->validate([
        //     'set_number' => 'required|integer',
        // ]);

        $recordExercise = RecordExercise::where('exercise_id', $exerciseId)
            ->where('set', $request->input('set_number'))
            ->first();

        if ($recordExercise) {
            return response()->json(['success' => true, 'notes' => $recordExercise->notes]);
        }

        return response()->json(['success' => false, 'message' => 'Record not found.']);
    }

    public function getRecordExercise(Request $request)
    {
        $date = $request->input('date', now()->format('Y-m-d')); // Default to today's date
        $userId = auth()->id(); // Get the logged-in user ID

        // Fetch all exercises done on the specified date
        $exercises = DB::table('record_exercises')
            ->join('exercises', 'record_exercises.exercise_id', '=', 'exercises.id')
            ->whereDate('record_exercises.created_at', $date) // Filter by date
            ->whereExists(function ($query) use ($userId) {
                $query->select(DB::raw(1))
                    ->from('records')
                    ->whereColumn('records.id', 'record_exercises.record_id')
                    ->where('records.user_id', $userId);
            })
            ->select(
                'exercises.name as exercise_name', // Exercise name from the `exercises` table
                'record_exercises.weight',
                'record_exercises.rep',
                'record_exercises.notes',
                'record_exercises.created_at'
            )
            ->get();
        
        // Log::info('Fetched exercises:', [
        //     'success' => true,
        //     'date' => $date,
        //     'exercises' => $exercises,
        // ]);
            

        return response()->json([
            'success' => true,
            'date' => $date,
            'exercises' => $exercises,
        ]);
    }


    public function getRecordsByExercise(Request $request)
    {
        $exerciseId = $request->input('exercise_id'); // Selected exercise ID
        $userId = auth()->id(); // Get logged-in user ID

        if (!$exerciseId) {
            return response()->json(['success' => false, 'message' => 'Please select a valid exercise.']);
        }

        // Get the date 6 months ago
        $sixMonthsAgo = now()->subMonths(6);

        // Fetch records for the selected exercise within the last 6 months
        $records = DB::table('record_exercises')
            ->join('exercises', 'record_exercises.exercise_id', '=', 'exercises.id')
            ->where('record_exercises.exercise_id', $exerciseId)
            ->where('record_exercises.created_at', '>=', $sixMonthsAgo)
            ->whereExists(function ($query) use ($userId) {
                $query->select(DB::raw(1))
                    ->from('records')
                    ->whereColumn('records.id', 'record_exercises.record_id')
                    ->where('records.user_id', $userId);
            })
            ->select(
                'record_exercises.created_at as date',
                'exercises.name as exercise_name',
                'record_exercises.weight',
                'record_exercises.rep'
            )
            ->orderBy('record_exercises.created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'records' => $records,
        ]);
    }

}
