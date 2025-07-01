<?php

namespace App\Http\Controllers;

use App\Models\BoardList;
use Illuminate\Http\Request;
use App\Models\BoardListModel;
use App\Models\Card;
use App\Models\Board;
use Carbon\Carbon;


class CardController extends Controller
{

    public function index(Request $request, Board $board)
{
    // Vérification que l’utilisateur a accès
    if (! $board->users->contains(auth()->id())) {
        abort(403);
    }

    $query = $board->cards(); // relation via les listes

    // Filtres
    if ($request->filled('title')) {
        $query->where('title', 'like', '%' . $request->title . '%');
    }

    if ($request->filled('description')) {
        $query->where('description', 'like', '%' . $request->description . '%');
    }

    $cards = $query->with('list')->get();

    return view('cards.index', compact('board', 'cards'));
}

    public function store(Request $request, BoardList $list)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $list->cards()->create([
        'title' => $request->title,
        'description' => $request->description,
        'category' => $request->category,
        'priority' => $request->priority,
        'due_date' => $request->due_date,
        'assigned_to' => $request->assigned_to,
        'created_by' => auth()->id(),
    ]);
    
    return redirect()->route('boards.show', $list->board_id)->with('success', 'Carte ajoutée');
}

public function edit(Card $card)
{
    return view('cards.edit', compact('card'));
    $card->load('list.board.users');

}

public function update(Request $request, Card $card)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'nullable|string|max:255',
        'priority' => 'nullable|in:basse,moyenne,élevée',
        'due_date' => 'nullable|date',
        'assigned_to' => 'nullable|exists:users,id',
    ]);

    $card->update([
        'title' => $request->title,
        'description' => $request->description,
        'category' => $request->category,
        'priority' => $request->priority,
        'due_date' => $request->due_date,
        'assigned_to' => $request->assigned_to,
    ]);

    return redirect()->route('boards.show', $card->list->board_id)->with('success', 'Carte mise à jour.');
}


public function destroy(Card $card)
{
    $card->delete();

    return back()->with('success', 'Carte supprimée.');
}


    public function move(Request $request, \App\Models\Card $card)
    {
        $request->validate([
            'list_id' => 'required|exists:board_lists,id',
        ]);

        // Vérifie que l'utilisateur est bien membre du tableau
        $board = $card->list->board;
        if (! $board->users->contains(auth()->id())) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $card->list_id = $request->list_id;
        $card->save();

        return response()->json(['success' => true]);
    }

    public function list(Board $board)
    {
        if (! $board->users->contains(auth()->id())) {
            abort(403, 'Accès interdit');
        }
    
        // Récupérer toutes les cartes liées à ce tableau
        $cards = \App\Models\Card::with('list')
            ->whereIn('list_id', $board->lists->pluck('id'))
            ->get();
    
        return view('cards.list', compact('board', 'cards'));
    }
    


}
