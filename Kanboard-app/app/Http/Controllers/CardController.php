<?php

namespace App\Http\Controllers;

use App\Models\BoardList;
use Illuminate\Http\Request;
use App\Models\BoardListModel;
use App\Models\Card;
use App\Models\Board;


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

    $list->cards()->create($request->only('title', 'description'));

    return redirect()->route('boards.show', $list->board_id)->with('success', 'Carte ajoutée');
}

public function edit(Card $card)
{
    return view('cards.edit', compact('card'));
}

public function update(Request $request, Card $card)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $card->update($request->only('title', 'description'));

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
