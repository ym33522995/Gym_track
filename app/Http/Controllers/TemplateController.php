<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Exercise;
use App\Models\TemplateContent;



class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Template $template)
    {
        //
        $userId = auth()->id(); 

        $templates = Template::where('user_id', $userId)->get();

        return view('gym_track.template')->with([
            'templates' => $templates
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Exercise $exercise)
    {
        //
        return view('gym_track.createTemplate')->with(['exercises' => $exercise->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Template $template)
    {
        $validate = $request->validate([
            'template_name' => 'required|string|max:255',
            'exercises' => 'sometimes|required|array',
        ]);

        $hasSelectedExercise = false;
        if ($request->has('exercises')) {
            foreach ($request->input('exercises') as $exerciseSets) {
                foreach ($exerciseSets as $exercise) {
                    if (isset($exercise['selected']) && $exercise['selected'] == 1) {
                        $hasSelectedExercise = true;
                        break 2; 
                    }
                }
            }
        }

        if ($hasSelectedExercise == false) {
            return redirect()->back()->withErrors(['exercises' => "You can't create an empty template."]);
        }

        $userId = Auth::id();
        if (!$userId) {
            return redirect('/login');
        }

        $input = [
            'name' => $request->input('template_name'),
            'user_id' => $userId,
        ];

        $template->fill($input)->save();

        $order = 0;
        foreach ($validate['exercises'] as $exerciseId => $exerciseSets) {
            foreach ($exerciseSets as $index => $exercise) {
                if (isset($exercise['selected'])) {
                    TemplateContent::create([
                        'template_id' => $template->id,
                        'exercise_id' => $exerciseId,
                        'weight' => $exercise['weight'] ?? null,
                        'rep' => $exercise['rep'] ?? null,
                        'set' => $exercise['set'] ?? null,
                        'order' => $order++,
                    ]);
                }
            }
        }

        return redirect('/template/' . $template->id);
    }



    public function delete(Template $template) {
        $template->delete();
        return redirect('/template');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
        // return view('gym_track.workout')->with('template', $template);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // 

        $template = Template::with('templateContents.exercise')->findOrFail($id);
        $newExercises = session()->get('new_exercises', []);
        // dd($newExercises);
        return view('gym_track.editTemplate')->with(['template' => $template, 'newExercises' => $newExercises]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $template = Template::findOrFail($id);
        $currentOrder = TemplateContent::where('template_id', $template->id)->count();

        $newExercises = session()->get('new_exercises', []);
        foreach ($newExercises as $exercise) {
            TemplateContent::create([
                'template_id' => $template->id,
                'exercise_id' => $exercise['exercise_id'],
                'weight' => $exercise['weight'],
                'rep' => $exercise['rep'],
                'set' => $exercise['set'],
                'order' => ++$currentOrder,
            ]);
        }

        session()->forget('new_exercises');
        session()->forget('workout_temp_data');

        return redirect('/template');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function quit()
    {
        session()->forget('new_exercises');
        session()->forget('workout_state');
        session()->forget('workout_temp_data');
        // session()->forget('return_url');
        return redirect('/template');
    }

    public function updateName(Request $request, $id)
    {
        $request->validate([
            'new_name' => 'required|string|max:255'
        ]);

        $template = Template::findOrFail($id);

        $template->update(['name' => $request->input('new_name')]);

        return redirect('/template');
    }

    public function deleteExercise(Request $request, Template $template)
    {
        $exerciseId = $request->input('exercise_id');
        $weight = $request->input('weight');
        $rep = $request->input('rep');

        $content = TemplateContent::where('template_id', $template->id)
            ->where('exercise_id', $exerciseId)
            ->where('weight', $weight)
            ->where('rep', $rep)
            ->first();

        if ($content) {
            if ($content->set > 1) {
                $content->set -= 1;
                $content->save();
            } else {
                $content->delete();
            }

            return response()->json(['success' => true, 'message' => 'Exercise updated successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Exercise not found.']);
    }

    public function duplicateExercise(Request $request, Template $template)
    {
        $exerciseId = $request->input('exercise_id');
        $weight = $request->input('weight');
        $rep = $request->input('rep');

        $content = TemplateContent::where('template_id', $template->id)
            ->where('exercise_id', $exerciseId)
            ->where('weight', $weight)
            ->where('rep', $rep)
            ->first();

        if ($content) {
            // Increment the set count
            $content->set += 1;
            $content->save();

            return response()->json(['success' => true, 'message' => 'Exercise duplicated successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Exercise not found.']);
    }

    public function saveCurrentRecord(Request $request, Template $template) 
    {
        session()->forget('new_exercises');
        $json = $request->input('record_state', '{}');
        $records = json_decode($json, true);

        session(['workout_temp_data' => $records]);

        return redirect("/workout/{$template->id}/addExercise?from=workout");
    }


    }
