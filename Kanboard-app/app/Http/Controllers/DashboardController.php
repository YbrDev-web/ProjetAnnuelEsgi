<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $Projects = Project::with('columns.tasks')->get();
        return view('dashboard', compact('projects'));
    }
}
