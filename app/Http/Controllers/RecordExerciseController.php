<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecordExercise;

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
            ->where('set', $request->input('set_number'))
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


}
