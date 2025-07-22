@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">

<div class="wrapper">
    <div class="dashboard">
        <h2>⚙️ Mon Profil</h2>

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success">Profil mis à jour avec succès.</div>
        @elseif(session('status') === 'password-updated')
            <div class="alert alert-success">Mot de passe mis à jour avec succès.</div>
        @endif

        <!-- Formulaire de mise à jour -->
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <label>Nom</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>

            <button type="submit" class="create-button">Mettre à jour mes infos</button>
        </form>

        <hr style="margin: 30px 0;">

        <!-- Changement de mot de passe -->
        <h3>🔐 Changer de mot de passe</h3>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <label for="current_password">Mot de passe actuel</label>
            <input type="password" name="current_password" required>

            <label for="password">Nouveau mot de passe</label>
            <input type="password" name="password" required>

            <label for="password_confirmation">Confirmer le nouveau mot de passe</label>
            <input type="password" name="password_confirmation" required>

            <button type="submit" class="small-button">Changer mon mot de passe</button>
        </form>

        <hr style="margin: 30px 0;">

        <!-- Suppression du compte -->
        <h3 style="color: red;">❌ Supprimer mon compte</h3>

        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Confirmer la suppression de votre compte ?')">
            @csrf
            @method('DELETE')

            <label>Mot de passe</label>
            <input type="password" name="password" required>

            <button type="submit" class="small-button" style="background-color: red;">Supprimer mon compte</button>
        </form>
    </div>
</div>
@endsection
