<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Record;
use App\Models\Exercise;
use App\Models\TemporaryRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Template $template)
    {
        //
        $userId = Auth::id();
        if (!$userId) {
            return redirect('/login');
        }

        $newExercises = session()->get('new_exercises', []);
        $temporaryRecords = TemporaryRecord::where('user_id', $userId)->get();

        if ($temporaryRecords->isEmpty()) {
            foreach ($template->templateContents as $content) {
                TemporaryRecord::create([
                    'user_id' => $userId,
                    'exercise_id' => $content->exercise_id,
                    'weight' => $content->weight,
                    'rep' => 1,
                    'set' => $content->set,
                    'notes' => null,
                ]);
            }
            $temporaryRecords = TemporaryRecord::where('user_id', $userId)->get();
        }

        return view('gym_track.workout')->with(['template' => $template, 'newExercises' => $newExercises, 'temporaryRecords' => $temporaryRecords]);
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
        $userId = Auth::id();
        if (!$userId) {
            return redirect('/login');
        }

        // dd($request->all());

        $record = new Record();
        $record->fill([
            'date' => now(),
            'user_id' => $userId,
        ])->save();

        foreach($request->input('records') as $exerciseId => $sets) {
            foreach($sets as $set) {
                if (isset($set['completed']) && $set['completed'] == 1) {
                    DB::table('record_exercises')->insert([
                        'record_id' => $record->id,
                        'exercise_id' => $exerciseId,
                        'weight' => $set['weight'],
                        'rep' => $set['rep'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return redirect('/report');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
        return view('gym_track.report');
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
    public function destroy(Template $template)
    {
        //
        $template->delete();
        return redirect('/template');
    }

    public function addExercise(Template $template)
    {
        $exercise = new Exercise();
        return view('gym_track.addExercise')->with(['exercises' => $exercise->get(), 'template' => $template]);
    }

    public function saveExercise(Request $request, Template $template)
    {
        $newExercises = $request->input('exercises');
        $formattedExercises = [];

        foreach ($newExercises as $exerciseId => $data) {
            if (isset($data['selected']) && $data['selected'] == 1) {
                $exercise = Exercise::find($exerciseId);
                $formattedExercises[$exerciseId] = [
                    'name' => $exercise->name,
                    'weight' => $data['weight'],
                    'rep' => $data['rep'],
                    'set' => $data['set'],
                ];
            }
        }

        // dd($formattedExercises);

        $existingExercises = session()->get('new_exercises', []);
        $mergedExercises = array_merge($existingExercises, $formattedExercises);

        // dd($mergedExercises);
        session()->put('new_exercises', $mergedExercises);
        // $returnURL = session()->get('return_url', route('workout.page', ['template' => $template->id]));
        return redirect("/template/{$template->id }");
    }

    public function saveTemporaryRecord(Request $request, Template $template)
    {
        $userId = Auth::id();
        if (!$userId) {
            return redirect('/login');
        }

        foreach ($request->input('records', []) as $exerciseId => $sets) {
            foreach ($sets as $setIndex => $set) {
                TemporaryRecord::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'exercise_id' => $exerciseId,
                        'set' => $setIndex,
                        'weight' => $set['weight'] ?? null,
                        'rep' => 1,
                        'notes' => $set['notes'] ?? null,
                    ]
                );
            }
        }

        return redirect("/workout/{$template->id}/addExercise");
    }





    public function clearTemporaryRecords()
    {
        $userId = Auth::id();
        if ($userId) {
            TemporaryRecord::where('user_id', $userId)->delete();
        }
    }

}
