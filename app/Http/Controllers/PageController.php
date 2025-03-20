<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function rules() {
        return view('pages.rules');
    }

    public function teams() {
        return view('pages.teams');
    }

    public function scoreboard() {
        return view('pages.scoreboard');
    }

    public function challenges() {
        return view('pages.challenges');
    }
}
