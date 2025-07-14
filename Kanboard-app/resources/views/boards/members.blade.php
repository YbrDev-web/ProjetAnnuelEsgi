@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/members.css') }}">

<div class="wrapper">
  <div class="dashboard">

    <h2>👥 Gérer le groupe associé au tableau : {{ $board->name }}</h2>
    <p>Description : {{ $board->description }}</p>

    <hr style="margin: 20px 0;">

    <!-- LISTE DES MEMBRES -->
    <h3>Membres actuels</h3>

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
      <thead>
        <tr style="background-color: #eee;">
          <th style="padding: 8px; text-align: left;">Nom</th>
          <th>Email</th>
          <th>Rôle</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr style="border-bottom: 1px solid #ccc;">
          <td style="padding: 8px;">{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>
            @if($user->id === $board->user_id)
              <strong>👑 Propriétaire</strong>
            @elseif(auth()->id() !== $user->id && ($authRole === 'admin' || auth()->id() === $board->user_id))
              <form method="POST" action="{{ route('boards.members.update', [$board, $user]) }}">
                @csrf
                @method('PATCH')
                <select name="role" onchange="this.form.submit()">
                  <option value="admin" {{ $user->pivot->role === 'admin' ? 'selected' : '' }}>Admin</option>
                  <option value="member" {{ $user->pivot->role === 'member' ? 'selected' : '' }}>Membre</option>
                  <option value="viewer" {{ $user->pivot->role === 'viewer' ? 'selected' : '' }}>Lecteur</option>
                </select>
              </form>
            @else
              <span class="badge {{ $user->pivot->role }}">{{ ucfirst($user->pivot->role) }}</span>
            @endif
          </td>
          <td>
            @if($user->id !== $board->user_id && $user->id !== auth()->id() && ($authRole === 'admin' || auth()->id() === $board->user_id))
              <form action="{{ route('boards.members.remove', [$board, $user]) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir retirer ce membre ?')" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="small-button" style="background-color: red;">Retirer</button>
              </form>
            @else
              —
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <hr style="margin: 30px 0;">

    <!-- FORMULAIRE POUR INVITER UN UTILISATEUR EXISTANT -->
    @if($authRole === 'admin' || auth()->id() === $board->user_id)
    <h3>➕ Inviter un membre</h3>

    <form action="{{ route('boards.members.invite', $board) }}" method="POST" style="max-width: 400px;">
      @csrf
      <label for="email">Email de l'utilisateur</label>
      <input type="email" name="email" required>

      <label for="role">Rôle</label>
      <select name="role" required>
        <option value="member">Membre</option>
        <option value="admin">Admin</option>
        <option value="viewer">Lecteur</option>
      </select>

      <button type="submit" class="create-button" style="margin-top: 10px;">Inviter</button>
    </form>
    @endif

    <br>
    <a href="{{ route('boards.show', $board) }}" style="text-decoration: underline; color: #007bff;">← Retour au tableau</a>
  </div>
</div>

<style>
  .badge.admin {
    background-color: #f0ad4e;
    color: white;
    padding: 2px 6px;
    border-radius: 4px;
  }
  .badge.member {
    background-color: #007bff;
    color: white;
    padding: 2px 6px;
    border-radius: 4px;
  }
  .badge.viewer {
    background-color: #6c757d;
    color: white;
    padding: 2px 6px;
    border-radius: 4px;
  }
</style>
@endsection
