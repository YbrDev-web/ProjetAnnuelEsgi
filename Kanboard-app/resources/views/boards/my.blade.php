@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/boards.css') }}">

<div class="layout">
  <!-- Sidebar -->
  <aside class="sidebar">
    <ul>
      <li><a href="{{ route('dashboard') }}">🏠 Tableau de bord</a></li>
      <li><a href="{{ route('boards.my') }}">📁 Mes tableaux</a></li>
      <li><a href="{{ route('groups.index') }}">👥 Groupes</a></li>
    </ul>
  </aside>

  <!-- Contenu principal -->
  <main class="dashboard">
    <div class="section-header">
      <h2>Vos tableaux</h2>
      <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <div class="search-bar">
          <input type="text" placeholder="Rechercher un tableau...">
        </div>
        <button class="create-button" onclick="openModal()">+ Créer un tableau</button>
      </div>
    </div>

    <div class="board-list">
      @forelse($boards as $board)
        <a href="{{ route('boards.show', $board) }}" class="board-card">
          <strong>{{ $board->name }}</strong>
          <div class="board-badge">{{ $board->description }}</div>
          <div class="board-badge">
            Rôle :
            @if($board->user_id === auth()->id())
              Propriétaire
            @else
              {{ ucfirst($board->pivot->role ?? 'membre') }}
            @endif
          </div>
        </a>
      @empty
        <p>Aucun tableau trouvé. Créez-en un !</p>
      @endforelse
    </div>
  </main>
</div>

<!-- Modal -->
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

<script>
  function openModal() {
    document.getElementById('boardModal').style.display = 'flex';
  }

  function closeModal() {
    document.getElementById('boardModal').style.display = 'none';
  }

  window.onclick = function (event) {
    const modal = document.getElementById('boardModal');
    if (event.target === modal) {
      closeModal();
    }
  }
</script>
@endsection
