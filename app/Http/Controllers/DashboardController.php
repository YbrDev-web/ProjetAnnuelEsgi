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

        // Récupérer tous les tableaux liés à l'utilisateur (propriétaire ou membre)
        $boards = $user->boards()->with('users')->get();

        return view('dashboard', compact('boards'));
    }
}
