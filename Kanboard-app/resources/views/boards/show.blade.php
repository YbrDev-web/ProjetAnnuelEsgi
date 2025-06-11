@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/board-show.css') }}">

<div class="wrapper">
  <h2>{{ $board->name }}</h2>
  <p>{{ $board->description }}</p>

  <div class="kanban-board">
    @forelse($board->lists as $list)
      <div class="list" data-list-id="{{ $list->id }}" data-terminal="{{ $list->is_terminal ? 'true' : 'false' }}">
        <h3>{{ $list->title }}</h3>

        <div class="card-container" ondrop="drop(event)" ondragover="allowDrop(event)">
          @foreach($list->cards as $card)
            <div class="card" 
                 draggable="true" 
                 ondragstart="drag(event)" 
                 id="card-{{ $card->id }}"
                 data-card-id="{{ $card->id }}">
              <strong>{{ $card->title }}</strong>
              <p>{{ $card->description ?? 'Aucune description.' }}</p>
            </div>
          @endforeach
        </div>

        <!-- Formulaire ajout carte -->
        <!-- Bouton pour ouvrir le modal -->
        <button class="open-modal-button" onclick="openCardModal({{ $list->id }})">+ Ajouter une carte</button>

      </div>
    @empty
      <p>Aucune colonne trouvée. Créez-en une !</p>
    @endforelse
  </div>
</div>
<!-- MODAL AJOUT DE CARTE -->
<div class="modal" id="cardModal">
  <div class="modal-content">
    <span class="close-modal" onclick="closeCardModal()">&times;</span>
    <h3>Ajouter une carte</h3>

    <form id="cardForm" method="POST">
      @csrf
      <input type="text" name="title" placeholder="Titre" required>
      <textarea name="description" placeholder="Description (facultatif)"></textarea>
      <button type="submit">Créer</button>
    </form>
  </div>
</div>

<a href="{{ route('cards.list', $board) }}" class="small-button">📄 Voir les tâches en liste</a>

<script>
  function allowDrop(ev) {
    ev.preventDefault();
  }

  function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
  }

  function drop(ev) {
    ev.preventDefault();
    const cardId = ev.dataTransfer.getData("text");
    const cardEl = document.getElementById(cardId);
    const targetList = ev.target.closest(".list");

    if (!targetList) return;

    const isTerminal = targetList.getAttribute('data-terminal') === 'true';
    if (isTerminal && !confirm("Cette colonne termine la tâche. Continuer ?")) return;

    // Affiche visuellement
    const container = targetList.querySelector(".card-container");
    container.appendChild(cardEl);

    // AJAX vers le backend
    const listId = targetList.getAttribute("data-list-id");

    fetch(`/cards/${cardEl.dataset.cardId}/move`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
      },
      body: JSON.stringify({ list_id: listId })
    }).then(res => {
      if (!res.ok) alert("Erreur de déplacement !");
    });
  }

  let cardForm = document.getElementById('cardForm');
  const modal = document.getElementById('cardModal');

  function openCardModal(listId) {
    cardForm.action = `/lists/${listId}/cards`; // Assure-toi que cette route existe
    modal.style.display = 'block';
  }

  function closeCardModal() {
    modal.style.display = 'none';
    cardForm.reset();
  }

  window.onclick = function (event) {
    if (event.target == modal) {
      closeCardModal();
    }
  }
</script>
@endsection
