<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    //
    public function show() {
        return view('calendars/calendar');
    }

    public function getRecordDates()
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json([], 401);
        }

        $recordDates = Record::where('user_id', $userId)
            ->select(DB::raw('DATE(date) as date'))
            ->distinct()
            ->pluck('date');

        // dd("THis method is being called.");
        return response()->json($recordDates);
    }

}
