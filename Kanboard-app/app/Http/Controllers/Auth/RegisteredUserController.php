<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Invitation;
use App\Notifications\WelcomeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Affiche le formulaire d’inscription.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Gère la création d’un nouvel utilisateur.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation des données
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'member',
        ]);

        // Envoi d’une notification de bienvenue
        $user->notify(new WelcomeNotification());

        // Déclenche l’événement d’enregistrement
        event(new Registered($user));

        // Connexion de l'utilisateur
        Auth::login($user);

        // ✅ Traitement d’une éventuelle invitation
        $token = Session::pull('invitation_token');

        if ($token) {
            $invitation = Invitation::where('token', $token)->first();

            if ($invitation && $invitation->email === $user->email) {
                if (! $invitation->board->users->contains($user->id)) {
                    $invitation->board->users()->attach($user->id, ['role' => $invitation->role]);
                }

                $invitation->delete();

                return redirect()->route('boards.show', $invitation->board)
                    ->with('success', 'Bienvenue ! Vous avez rejoint le tableau "' . $invitation->board->name . '" avec succès.');
            } else {
                return redirect()->route('dashboard')
                    ->with('error', 'Votre adresse e-mail ne correspond pas à l’invitation.');
            }
        }

        // Redirection normale après inscription sans invitation
        return redirect()->route(
            $user->role === 'admin' ? 'admin.dashboard' : 'dashboard'
        );
    }
}
