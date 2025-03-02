<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Record;
use App\Models\Exercise;
use App\Models\TemporaryRecord;
use App\Models\TemplateContent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use GeminiAPI\Client;
use Illuminate\Support\Facades\Session;



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
        // dd($newExercises);

        $state = session()->get('workout_temp_data', []);
        // dd($state);

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

        return view('gym_track.workout')->with(['template' => $template, 'newExercises' => $newExercises, 'temporaryRecords' => $temporaryRecords, 'state' => $state]);
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
        // dd($request->all());
        $validate = $request->validate([
            'records' => ['required', 'array', function ($attribute, $value, $fail) {
                $hasCompletedExercise = collect($value)->flatten(1)
                    ->contains(fn($set) => isset($set['completed']) && $set['completed'] == "1");
        
                if (!$hasCompletedExercise) {
                    $fail("At least one exercise must be marked as completed. Click 'Quit Exercise' if you want to exit.");
                }
            }],
        ]);
        

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

        // foreach($request->input('records') as $exerciseId => $sets) {
        //     foreach($sets as $set) {
        //         if (isset($set['completed']) && $set['completed'] == 1) {
        //             DB::table('record_exercises')->insert([
        //                 'record_id' => $record->id,
        //                 'exercise_id' => $exerciseId,
        //                 'weight' => $set['weight'],
        //                 'rep' => $set['rep'],
        //                 'notes' => $set['notes'] ?? null,
        //                 'created_at' => now(),
        //                 'updated_at' => now(),
        //             ]);
        //         }
        //     }
        // }

        foreach($request->input('records') as $contentKey => $sets) {
            foreach($sets as $set) {
                $exerciseId = $set['exercise_id'];
                if (!empty($set['completed'])) {
                    DB::table('record_exercises')->insert([
                        'record_id'   => $record->id,
                        'exercise_id' => $exerciseId,
                        'weight'      => $set['weight'] ?? 0,
                        'rep'         => $set['rep'] ?? 0,
                        'notes'       => $set['notes'] ?? null,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);
                }
            }
        }        

        session()->forget('new_exercises');
        session()->forget('workout_temp_data');
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

    public function addExercise(Template $template, Request $request)
    {
        $exercise = new Exercise();
        $from = $request->query('from', 'workout');
        return view('gym_track.addExercise')->with(['exercises' => $exercise->get(), 'template' => $template, 'from' => $from]);
    }

    // public function saveExercise(Request $request, Template $template)
    // {
    //     $newExercises = $request->input('exercises',[]);
    //     $formattedExercises = [];

    //     foreach ($newExercises as $exerciseId => $data) {
    //         if (isset($data['selected']) && $data['selected'] == 1) {
    //             $exercise = Exercise::find($exerciseId);
    //             $formattedExercises[$exerciseId] = [
    //                 'exercise_id' => $exerciseId,
    //                 'name' => $exercise->name,
    //                 'weight' => $data['weight'],
    //                 'rep' => $data['rep'],
    //                 'set' => $data['set'],
    //                 'notes' => $data['notes'] ?? null,
    //             ];
    //         }
    //     }

    //     $template = Template::findOrFail($template->id);
    //     $currentOrder = (TemplateContent::where('template_id', $template->id)->count())+1;
        
    //     $newExercises = session()->get('new_exercises', []);
    //     foreach ($newExercises as $exercise) {
    //         TemplateContent::create([
    //             'template_id' => $template->id,
    //             'exercise_id' => $exercise['exercise_id'],
    //             'weight' => $exercise['weight'],
    //             'rep' => $exercise['rep'],
    //             'set' => $exercise['set'],
    //             'order' => ++$currentOrder,
    //         ]);
    //     }

    //     // session()->forget('new_exercises');

    //     // dd($newExercises);

    //     $existingExercises = session()->get('new_exercises', []);
    //     $mergedExercises = array_merge($existingExercises, $formattedExercises);

    //     // dd($mergedExercises);
    //     session()->put('new_exercises', $mergedExercises);
    //     $from = $request->input('from', 'workout');
    //     if ($from === 'editTemplate') {
    //         return redirect("/template/edit/{$template->id}");
    //     }

    //     return redirect("/template/{$template->id }");
    // }

    public function saveExercise(Request $request, Template $template)
    {

        $newExercises = $request->input('exercises', []);
        $formattedExercises = [];

        foreach ($newExercises as $exerciseId => $data) {
            if (!empty($data['selected'])) {
                $exercise = Exercise::findOrFail($exerciseId);
                $formattedExercises[$exerciseId] = [
                    'exercise_id' => $exerciseId,
                    'name'        => $exercise->name,
                    'weight'      => $data['weight'],
                    'rep'         => $data['rep'],
                    'set'         => $data['set'],
                    'notes'       => $data['notes'] ?? null,
                ];
            }
        }

        // dd($formattedExercises);

        $template = Template::findOrFail($template->id);
        $currentOrder = TemplateContent::where('template_id', $template->id)->count() + 1;

        foreach ($formattedExercises as $exerciseData) {
            TemplateContent::create([
                'template_id' => $template->id,
                'exercise_id' => $exerciseData['exercise_id'],
                'weight'      => $exerciseData['weight'],
                'rep'         => $exerciseData['rep'],
                'set'         => $exerciseData['set'],
                'order'       => $currentOrder++,
            ]);
        }

        
        $oldSessionExercises = session()->get('new_exercises', []);

        foreach ($formattedExercises as $exerciseId => $exerciseData) {
            if (isset($oldSessionExercises[$exerciseId])) {
                // $oldSessionExercises[$exerciseId] = $exerciseData;
                unset($oldSession[$exerciseId]);
            }
        }

        session()->put('new_exercises', $oldSessionExercises);

        $from = $request->input('from', 'workout');
        if ($from === 'editTemplate') {
            return redirect("/template/edit/{$template->id}");
        }

        return redirect("/template/{$template->id}");
    }



    public function totalWeights()
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json([], 401);
        }

        $totalWeight = RECORD::where('user_id', $userId)
            ->with('recordExercises')
            ->get()
            ->flatMap(function($record) {  // Extracts all recordExercises across all the user's records into a single collection.
                return $record->recordExercises;
            })
            ->sum(function($exercise) {
                return $exercise->weight * $exercise->rep;
            });
        
        return $totalWeight;
    }

    function convertTotalWeight() {
        
    }


    public function editWorkout($id)
    {
        $template = Template::with('templateContents.exercise')->findOrFail($id);
        return view('gym_track.editWorkout', compact('template'));
    }

    public function saveWorkoutEdits(Request $request, $id)
    {
        $request->validate([
            'exercises' => 'required|array',
        ]);

        $template = Template::findOrFail($id);
        $changesReflected = $request->input('reflect_changes') === 'yes';

        if ($changesReflected) {
            TemplateContent::where('template_id', $template->id)->delete();
            foreach ($request->exercises as $exerciseId => $data) {
                foreach ($data['sets'] as $setIndex => $set) {
                    TemplateContent::create([
                        'template_id' => $template->id,
                        'exercise_id' => $exerciseId,
                        'weight' => $set['weight'],
                        'rep' => $set['rep'],
                        'set' => $setIndex,
                    ]);
                }
            }
        }

        return redirect('/template');
    }


    public function saveTimer(Request $request)
    {
        $elapsedTime = $request->input('elapsed_time', 0);
        $isReset = $request->input('reset') === 'true';

        \Log::info("saveTimer received elapsed time: $elapsedTime | Reset: " . ($isReset ? 'Yes' : 'No') . " | Session Before: " . json_encode(session()->all()));

        if ($isReset) {
            // Clear timer session completely
            session()->forget('workout_timer');
            session()->save();
            \Log::info("Timer reset successfully. | Session After Reset: " . json_encode(session()->all()));
            return response()->json(['success' => true, 'elapsed_time' => 0]);
        }

        // Only update if reset was NOT requested
        if (session()->has('workout_timer')) {
            session()->put('workout_timer', $elapsedTime);
            session()->save();
            \Log::info("Session updated with elapsed time: $elapsedTime | Session After Update: " . json_encode(session()->all()));
        } else {
            \Log::warning("Attempted to update timer after reset, ignoring.");
        }

        return response()->json(['success' => true, 'elapsed_time' => $elapsedTime]);
    }


    public function getTimer()
    {
        // Ensure session value is properly retrieved
        $elapsedTime = session()->get('workout_timer', 0);

        \Log::info("getTimer returning elapsed time: $elapsedTime | Session Data: " . json_encode(session()->all()));
        
        return response()->json(['elapsed_time' => $elapsedTime]);
    }



}
