<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;
use App\Models\Board;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;


class InvitationController extends Controller
{
    

    public function accept(Request $request, $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();
    
        if (! $request->hasValidSignature()) {
            abort(403, 'Lien expiré ou invalide.');
        }
    
        // Stocke le token dans la session pour traitement après login/register
        session(['invitation_token' => $token]);
    
        // Vérifie si un utilisateur avec cet email existe déjà
        if (User::where('email', $invitation->email)->exists()) {
            // Rediriger vers login si l'utilisateur a déjà un compte
            return redirect()->route('login')->with('info', 'Connectez-vous pour accepter l’invitation.');
        }
    
        // Sinon, rediriger vers register
        return redirect()->route('register')->with('info', 'Créez un compte pour accepter l’invitation.');
    }
    

}