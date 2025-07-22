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

        $cards = \App\Models\Card::with('list')
            ->whereIn('list_id', $board->lists->pluck('id'))
            ->get();

        return view('cards.list', compact('board', 'cards'));
    }

    public function calendar(Board $board)
    {
        // Vérifier l'accès
        if (!$board->users->contains(auth()->id())) {
            abort(403, 'Accès interdit');
        }

        // Récupérer toutes les cartes avec une date limite
        $cards = Card::with(['list', 'assignedTo', 'createdBy'])
            ->whereIn('list_id', $board->lists->pluck('id'))
            ->whereNotNull('due_date')
            ->get()
            ->map(function ($card) {
                return [
                    'id' => $card->id,
                    'title' => $card->title,
                    'start' => $card->due_date,
                    'end' => $card->due_date,
                    'description' => $card->description,
                    'category' => $card->category,
                    'priority' => $card->priority,
                    'list_title' => $card->list->title,
                    'assigned_to' => $card->assignedTo ? $card->assignedTo->name : 'Non assigné',
                    'created_by' => $card->createdBy ? $card->createdBy->name : 'Inconnu',
                    'backgroundColor' => $this->getPriorityColor($card->priority),
                    'borderColor' => $this->getPriorityColor($card->priority),
                    'textColor' => '#fff'
                ];
            });

        return view('boards.calendar', compact('board', 'cards'));
    }

    private function getPriorityColor($priority)
    {
        return match ($priority) {
            'élevée' => '#dc2626',  // rouge
            'moyenne' => '#f59e0b', // orange
            'basse' => '#10b981',   // vert
            default => '#6b7280'    // gris
        };
    }

    // Ajouter ces méthodes dans votre CardController

    public function updateDate(Request $request, Card $card)
    {
        // Vérifier que l'utilisateur a accès
        $board = $card->list->board;
        if (!$board->users->contains(auth()->id())) {
            return response()->json(['success' => false, 'message' => 'Accès interdit'], 403);
        }

        $request->validate([
            'due_date' => 'required|date'
        ]);

        $card->due_date = $request->due_date;
        $card->save();

        return response()->json([
            'success' => true,
            'message' => 'Date mise à jour avec succès',
            'card' => $card
        ]);
    }

    // Méthode améliorée pour stocker une carte depuis le calendrier
    public function storeFromCalendar(Request $request, BoardList $list)
    {
        // Vérifier l'accès au board
        if (!$list->board->users->contains(auth()->id())) {
            return response()->json(['success' => false, 'message' => 'Accès interdit'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'priority' => 'nullable|in:basse,moyenne,élevée',
            'due_date' => 'required|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $card = $list->cards()->create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'assigned_to' => $request->assigned_to,
            'created_by' => auth()->id(),
        ]);

        // Charger les relations pour la réponse
        $card->load(['assignedTo', 'list']);

        return response()->json([
            'success' => true,
            'message' => 'Tâche créée avec succès',
            'card' => $card,
            'list_title' => $list->title,
            'assigned_to_name' => $card->assignedTo ? $card->assignedTo->name : null
        ]);
    }

    // Méthode pour obtenir les événements du calendrier (amélioration)
    public function calendarEvents(Board $board)
    {
        if (!$board->users->contains(auth()->id())) {
            return response()->json(['error' => 'Accès interdit'], 403);
        }

        $cards = Card::with(['list', 'assignedTo', 'createdBy'])
            ->whereIn('list_id', $board->lists->pluck('id'))
            ->whereNotNull('due_date')
            ->get()
            ->map(function ($card) {
                return [
                    'id' => $card->id,
                    'title' => $card->title,
                    'start' => $card->due_date,
                    'end' => $card->due_date,
                    'backgroundColor' => $this->getPriorityColor($card->priority),
                    'borderColor' => $this->getPriorityColor($card->priority),
                    'textColor' => '#fff',
                    'extendedProps' => [
                        'description' => $card->description,
                        'category' => $card->category,
                        'priority' => $card->priority,
                        'list_title' => $card->list->title,
                        'assigned_to' => $card->assignedTo ? $card->assignedTo->name : 'Non assigné',
                        'created_by' => $card->createdBy ? $card->createdBy->name : 'Inconnu',
                        'originalDate' => $card->due_date
                    ]
                ];
            });

        return response()->json($cards);
    }
}
