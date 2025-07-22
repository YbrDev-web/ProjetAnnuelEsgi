<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;

class GroupController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Récupère tous les tableaux liés à l'utilisateur
        $groups = $user->boards()->with('users')->get();

        return view('groups.index', compact('groups'));
    }
}
