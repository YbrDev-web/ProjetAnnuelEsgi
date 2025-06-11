<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\User;



class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $boards = $user->boards()->with('users')->get();
        $allUsers = User::all(); // ✅ Ajouter cette ligne

        return view('dashboard', compact('boards', 'allUsers'));
    }


}


