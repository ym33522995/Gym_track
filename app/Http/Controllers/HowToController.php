<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HowToController extends Controller
{
    //
    public function index() {
        return view('gym_track.howTo');
    }
}
