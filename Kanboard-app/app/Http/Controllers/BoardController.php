<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\User;
use App\Notifications\GroupInvitationNotification;
use Illuminate\Support\Str;
use App\Models\Invitation;
use App\Models\BoardList;




class BoardController extends Controller
{
    public function myBoards()
    {
        $user = auth()->user();

        $boards = $user->boards()->with('users')->get();
        $allUsers = User::all(); // ✅ Ajouter cette ligne
    
        return view('boards.my', compact('boards', 'allUsers'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        $board = Board::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
        ]);
    
        // Le créateur devient membre
        $board->users()->attach(auth()->id(), ['role' => 'admin']);
    
        // ✅ Colonnes par défaut
        $defaultLists = ['À faire', 'En cours', 'Fait', 'Annulé'];
    
        foreach ($defaultLists as $title) {
            $board->lists()->create([
                'title' => $title,
                'is_terminal' => in_array($title, ['Fait', 'Annulé']),
            ]);
        }
    
        return redirect()->route('dashboard')->with('success', 'Tableau créé avec ses colonnes.');
    }
    
    public function addMember(Request $request, Board $board)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        if (!$board->users->contains($request->user_id)) {
            $board->users()->attach($request->user_id, ['role' => 'member']);
        }

        return back()->with('success', 'Utilisateur ajouté au tableau.');
    }

    public function members(Board $board)
    {
        if ($board->user_id !== auth()->id()) {
            abort(403);
        }

        $users = $board->users;
        $allUsers = User::all();

        return view('boards.members', compact('board', 'users', 'allUsers'));
    }

   
    public function invite(Request $request, Board $board)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'role' => 'required|in:admin,member,viewer'
        ]);
    
        $user = User::where('email', $request->email)->first();
        $token = Str::random(40);
    
        // Crée une invitation si elle n’existe pas déjà
        if (!Invitation::where('user_id', $user->id)->where('board_id', $board->id)->exists()) {
            Invitation::create([
                'board_id' => $board->id,
                'user_id' => $user->id,
                'role' => $request->role,
                'token' => $token,
            ]);
    
            $user->notify(new GroupInvitationNotification($board, $token));
        }
    
        return back()->with('success', 'Invitation envoyée.');
    }



    public function updateRole(Request $request, Board $board, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,member,viewer'
        ]);

        $board->users()->updateExistingPivot($user->id, ['role' => $request->role]);

        return back()->with('success', 'Rôle mis à jour.');
    }

    public function removeMember(Board $board, User $user)
    {
        $authUser = auth()->user();

        // Le propriétaire ne peut pas se retirer
        if ($user->id === $board->user_id) {
            return back()->with('error', 'Le créateur ne peut pas quitter le groupe.');
        }

        // Un utilisateur peut se retirer lui-même OU être retiré par le propriétaire
        if ($authUser->id !== $user->id && $authUser->id !== $board->user_id) {
            abort(403);
        }

        $board->users()->detach($user->id);

        return back()->with('success', 'Vous avez quitté le groupe.');
    }

    public function project(Board $board)
    {
        if (!$board->users->contains(auth()->id())) {
            abort(403);
        }
    
        $board->load('lists.cards');
    
        return view('boards.project', compact('board'));
    }
    // App\Http\Controllers\BoardController.php

    public function show(Board $board)
    {
        if (! $board->users->contains(auth()->id())) {
            abort(403, 'Accès interdit');
        }
    
        $board->load('lists.cards'); // Assure que 'lists' est bien la relation correcte
    
        return view('boards.show', compact('board'));
    }
    
}
