@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="wrapper">

  <!-- Message de bienvenue -->
  <div class="welcome">
    👋 Bienvenue, {{ Auth::user()->name }} !
  </div>

  <!-- Contenu principal -->
  <div class="main-container">

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
      <ul>
        <li><a href="{{ route('dashboard') }}">🏠 Tableau de bord</a></li>
        <li><a href="{{ route('boards.my') }}">📁 Mes tableaux</a></li>
        <li><a href="{{ route('groups.index') }}">👥 Groupes</a></li>
        <li><a href="{{ route('settings.index') }}">⚙️ Paramètres</a></li>
        <li><a href="{{ route('help.index') }}">❓ Aide</a></li>
      </ul>
    </aside>

    <!-- Zone dashboard -->
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
</a>
        @empty
          <p>Aucun tableau trouvé. Créez-en un !</p>
        @endforelse
      </div>

    </main>
  </div>

  <!-- Footer -->
  <footer class="footer">
    © {{ now()->year }} MonApp. Inspiré de Trello.
  </footer>
</div>

<!-- Modal création tableau -->
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

<!-- JS -->
<script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
