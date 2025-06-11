<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\ListModel;

class ListController extends Controller
{
    public function store(Request $request, Board $board)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
    
        $board->lists()->create([
            'title' => $request->title,
        ]);
    
        return redirect()->route('boards.show', $board)->with('success', 'Liste créée.');
    }
    
}
