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
        return view('gym_track.template')->with(['templates' => $template->get()]);
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
            'exercises' => 'required|array',
            // 'exercises.*.selected' => 'required|boolean',
            // 'exercises.*.weight' => 'required_if:exercises.*.selected,1|numeric',
            // 'exercises.*.rep' => 'required_if:exercises.*.selected,1|integer',
            // 'exercises.*.set' => 'required_if:exercises.*.selected,1|integer',
        ]);

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
        foreach ($validate['exercises'] as $exerciseId => $exercise) {
            if (isset($exercise['selected'])) {
                TemplateContent::create([
                    'template_id' => $template->id,
                    'exercise_id' => $exerciseId,
                    'weight' => $exercise['weight'],
                    'rep' => $exercise['rep'],
                    'set' => $exercise['set'],
                    'order' => $order++,
                ]);
            }
        }

        return redirect('/template/ . {template}');
    }


    public function delete(Template $template) {
        $template->delete();
        return redirect('/template');
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template)
    {
        //
        return view('gym_track.workout')->with('template', $template);
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
}
