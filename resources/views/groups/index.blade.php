@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/groups.css') }}">

<main class="dashboard">
  <div class="section-header">
    <h2>👥 Mes Groupes</h2>
    <p>Voici les groupes (tableaux) auxquels vous participez.</p>
  </div>

  <div class="board-list">
    @forelse($groups as $group)
      <div class="board-card">
        <strong>{{ $group->name }}</strong>
        <div class="board-badge">{{ $group->description }}</div>

        <!-- Badge de rôle -->
        <div class="board-badge" style="margin-top: 5px;">
          Rôle :
          @if($group->user_id === auth()->id())
            Propriétaire
          @else
            {{ ucfirst($group->pivot->role ?? 'membre') }}
          @endif
        </div>

        <!-- Liste des membres -->
        <div class="board-badge" style="margin-top: 10px;">
          Membres :
          <ul style="padding-left: 15px; list-style: disc;">
            @foreach($group->users as $user)
              <li style="font-size: 0.85rem;">👤 {{ $user->name }}</li>
            @endforeach
          </ul>
        </div>

        <!-- Gérer les membres (pour le créateur) -->
        @if($group->user_id === auth()->id())
          <div style="margin-top: 10px;">
            <a href="{{ route('boards.members', $group) }}"
               class="small-button"
               style="background-color: #007bff; color: white; padding: 6px 10px; border-radius: 5px; text-decoration: none;">
              ⚙️ Gérer les membres
            </a>
          </div>
        @endif

        <!-- Quitter le groupe (si non propriétaire) -->
        @if($group->user_id !== auth()->id())
          <form action="{{ route('boards.removeMember', [$group, auth()->user()]) }}"
                method="POST"
                style="margin-top: 10px;"
                onsubmit="return confirm('Êtes-vous sûr de vouloir quitter ce groupe ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="small-button">
              ❌ Quitter le groupe
            </button>
          </form>
        @endif
      </div>
    @empty
      <p>Vous ne faites partie d’aucun groupe pour le moment.</p>
    @endforelse
  </div>
</main>
@endsection
