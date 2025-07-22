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
            <input type="text" id="searchInput" placeholder="Rechercher un tableau...">
          </div>
          <button class="create-button" onclick="openModal()">+ Créer un tableau</button>
        </div>
      </div>

      <!-- Liste des tableaux -->
      <div class="board-list">
      @forelse($boards as $board)
  <div class="board-card-wrapper">
    <a href="{{ route('boards.show', $board) }}" class="board-card" style="text-decoration: none; color: inherit;">
      @if($board->image)
        <img src="{{ asset('storage/' . $board->image) }}" alt="Image du tableau" width="200">
      @endif
      <strong>{{ $board->name }}</strong>
      <div class="board-badge">{{ $board->description }}</div>
    </a>

    @if($board->user_id === auth()->id())
      <form action="{{ route('boards.destroy', $board) }}" method="POST" style="margin-top: 5px;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Supprimer ce tableau ?')" style="color: red;">🗑️ Supprimer</button>
      </form>
    @endif
  </div>
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
    <form action="{{ route('boards.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
  <label for="boardName">Nom du tableau</label>
  <input type="text" id="boardName" name="name" required>

  <label for="description">Description</label>
  <textarea id="description" name="description" rows="3"></textarea>

  <label for="image">Image du tableau</label>
  <input type="file" id="image" name="image" accept="image/*">

  <button type="submit">Créer</button>
</form>

  </div>
</div>

<!-- JS -->
<script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
