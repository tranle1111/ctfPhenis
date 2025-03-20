<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Database;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    protected $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function index()
    {
        return view('admin');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'category' => 'required|string',
            'solves' => 'required|integer',
        ]);

        $data = [
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'solves' => (int) $request->input('solves')
        ];

        $this->database->getReference('challenges')->push($data);

        return redirect()->route('admin')->with('success', 'Challenge added successfully!');
    }
}
