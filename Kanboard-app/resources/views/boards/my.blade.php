@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/boards.css') }}">

<main class="dashboard">
  <div class="section-header">
    <h2>Vos tableaux</h2>
    <div style="display: flex; gap: 10px;">
      <div class="search-bar">
        <input type="text" placeholder="Rechercher un tableau...">
      </div>
      <button class="create-button" onclick="openModal()">+ Créer un tableau</button>
    </div>
  </div>

  <!-- Liste des tableaux -->
  <div class="board-list">
    @forelse($boards as $board)
    <a href="{{ route('boards.show', $board) }}" class="board-card" style="text-decoration: none; color: inherit;">
  <strong>{{ $board->name }}</strong>
  <div class="board-badge">{{ $board->description }}</div>
  <div class="board-badge" style="margin-top: 5px;">
    Rôle :
    @if($board->user_id === auth()->id())
      Propriétaire
    @else
      {{ ucfirst($board->pivot->role ?? 'membre') }}
    @endif
  </div>
  <button
  onclick="openRoleModal({{ $board->id }}, {{ auth()->id() }}, '{{ $board->pivot->role }}')"
  class="btn-role">
  Modifier mon rôle
</button>

</a>

    @empty
      <p>Aucun tableau trouvé. Créez-en un !</p>
    @endforelse
  </div>
</main>

<!-- Modal de création -->
<div class="modal" id="boardModal">
  <div class="modal-content">
    <span class="close-modal" onclick="closeModal()">&times;</span>
    <h3>Créer un nouveau tableau</h3>
    <form action="{{ route('boards.store') }}" method="POST">
      @csrf
      <label for="boardName">Nom du tableau</label>
      <input type="text" id="boardName" name="name" required>

      <label for="description">Description</label>
      <textarea id="description" name="description" rows="3"></textarea>

      <button type="submit">Créer</button>
    </form>
  </div>
</div>

<!-- Modal de modification de rôle -->
<!-- Modal de modification de rôle -->
<div class="modal" id="roleModal">
  <div class="modal-content">
    <span class="close-modal" onclick="closeRoleModal()">&times;</span>
    <h3>Modifier votre rôle</h3>
    <form id="roleForm" method="POST">
      @csrf
      @method('PATCH')

      <label for="roleSelect">Choisissez un rôle</label>
      <select name="role" id="roleSelect" required>
        <option value="admin">Admin</option>
        <option value="member">Membre</option>
        <option value="viewer">Lecteur</option>
      </select>

      <button type="submit">Mettre à jour</button>
    </form>
  </div>
</div>

<!-- Ton script à coller juste avant la fin -->




<script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
