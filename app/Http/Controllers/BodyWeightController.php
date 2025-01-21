<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BodyWeight;

class BodyWeightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'weight' => 'required|numeric',
            'date' => 'nullable|date',
        ]);

        $userId = Auth::id();

        $date = $request->input('date') ?: date('Y-m-d');

        $existing = BodyWeight::where('user_id', $userId)->where('date', $date)->first();

        if ($existing) {
            $existing->update([
                'weight' => $request->input('weight'),
            ]);
        } else {
            BodyWeight::create([
                'user_id' => $userId,
                'date' => $date,
                'weight' => $request->input('weight'),
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function getDate(Request $request)
    {
        $userId = Auth::id(); 

        // $endDate = $request->input('endDate') ?? date('Y-m-d');
        // $startDate = $request->input('startDate') ?? date('Y-m-d', strtotime('-2 weeks', strtotime($endDate)));


        $endDate = $request->input('endDate');
        $startDate = $request->input('startDate');

        $data = BodyWeight::where('user_id', $userId)->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'ASC')->get();

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
