<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\User;
use App\Models\Invitation;
use App\Models\BoardList;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Notifications\GroupInvitationNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;





class BoardController extends Controller
{
    public function myBoards()
    {
        $user = auth()->user();
        $boards = $user->boards()->with('users')->get();
        $allUsers = User::all();

        return view('boards.my', compact('boards', 'allUsers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('boards', 'public');
        }

        $board = Board::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?? null,
            'user_id' => auth()->id(),
        ]);

        $board->users()->attach(auth()->id(), ['role' => 'admin']);

        foreach (['À faire', 'En cours', 'Fait', 'Annulé'] as $title) {
            $board->lists()->create([
                'title' => $title,
                'is_terminal' => in_array($title, ['Fait', 'Annulé']),
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Tableau créé avec image.');
    }

    public function show(Board $board)
{
    if (! $board->users->contains(auth()->id())) {
        abort(403, 'Accès interdit');
    }

    $board->load('lists.cards.assignedTo', 'lists.cards.createdBy', 'users');

    // Ajoute ce bloc pour que $authRole soit défini
    $authUser = $board->users()->where('user_id', auth()->id())->first();
    $authRole = $authUser->pivot->role ?? 'member';

    return view('boards.show', compact('board', 'authRole'));
}
    
    public function project(Board $board)
    {
        if (!$board->users->contains(auth()->id())) {
            abort(403);
        }

        $board->load('lists.cards');

        return view('boards.project', compact('board'));
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
        $authUser = $board->users()->where('user_id', auth()->id())->first();
        if (!$authUser) {
            abort(403);
        }

        $authRole = $authUser->pivot->role ?? 'member';
        $users = $board->users;
        $allUsers = User::all();

        return view('boards.members', compact('board', 'users', 'allUsers', 'authRole'));
    }

    public function invite(Request $request, Board $board)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:admin,member,viewer',
        ]);
    
        $token = Str::random(40);
        $email = $request->email;
        $role = $request->role;
    
        $user = User::where('email', $email)->first();
    
        if ($user) {
            $alreadyInvited = Invitation::where('user_id', $user->id)
                ->where('board_id', $board->id)
                ->exists();
    
            if (! $alreadyInvited) {
                Invitation::create([
                    'board_id' => $board->id,
                    'user_id' => $user->id,
                    'role' => $role,
                    'token' => $token,
                ]);
    
                $user->notify(new GroupInvitationNotification($board, $token));
            }
        } else {
            $alreadyInvited = Invitation::where('email', $email)
                ->where('board_id', $board->id)
                ->exists();
    
            if (! $alreadyInvited) {
                Invitation::create([
                    'board_id' => $board->id,
                    'email' => $email,
                    'role' => $role,
                    'token' => $token,
                ]);
    
                // ✅ Envoie l'email manuellement
                Notification::route('mail', $email)->notify(new GroupInvitationNotification($board, $token));
            }
        }
    
        return back()->with('success', 'Invitation envoyée avec succès.');
    }

    public function updateRole(Request $request, Board $board, User $user)
    {
        $authUser = $board->users()->where('user_id', auth()->id())->first();
        if (!$authUser || !in_array($authUser->pivot->role, ['admin', 'owner'])) {
            abort(403, 'Non autorisé.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas modifier votre propre rôle.');
        }

        $data = $request->validate([
            'role' => 'required|in:admin,member,viewer'
        ]);

        $board->users()->updateExistingPivot($user->id, ['role' => $data['role']]);

        return back()->with('success', 'Rôle mis à jour.');
    }

    public function removeMember(Board $board, User $user)
    {
        $authUser = auth()->user();

        if ($user->id === $board->user_id) {
            return back()->with('error', 'Le créateur ne peut pas quitter le groupe.');
        }

        if ($authUser->id !== $user->id && $authUser->id !== $board->user_id) {
            abort(403);
        }

        $board->users()->detach($user->id);

        return back()->with('success', 'Membre retiré du tableau.');
    }

    public function destroy(Board $board)
    {
        if ($board->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer ce tableau.');
        }

        if ($board->image) {
            Storage::disk('public')->delete($board->image);
        }

        $board->delete();

        return redirect()->route('dashboard')->with('success', 'Tableau supprimé avec succès.');
    }
}
