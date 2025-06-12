<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    public function accept($token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        $invitation->board->users()->attach($invitation->user_id, [
            'role' => $invitation->role,
        ]);

        $invitation->delete();

        return redirect()->route('dashboard')->with('success', 'Vous avez rejoint le groupe.');
    }
}