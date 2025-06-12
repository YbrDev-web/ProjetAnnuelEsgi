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

        // Récupère tous les tableaux liés à l'utilisateur
        $boards = $user->boards()->with('users')->get();

        // Ajoute tous les utilisateurs (nécessaire si la vue utilise $allUsers)
        $allUsers = User::all();

        return view('dashboard', compact('boards', 'allUsers'));
    }
}
