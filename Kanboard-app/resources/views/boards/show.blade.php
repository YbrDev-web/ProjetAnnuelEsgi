@php($hideNavigation = true)
@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/board-show.css') }}">

{{-- === HEADER TRELL0-LIKE === --}}
<div class="board-header">
  <div class="title">
    <i class="fa fa-columns"></i> {{-- ou votre icône --}}
    {{ $board->name }}
  </div>
  <div class="actions">
  <div class="actions">
    @if($board->user_id === auth()->id())
      <button class="small-button" onclick="openInviteModal()">Partager</button>
    @endif
</div>

  </div>
</div>
<div class="menu_tableau" style="display: flex; flex-direction: row; gap: 20px; justify-content:center;">
  <a href="{{ route('cards.list', $board) }}" style="color: white;">Voir les tâches en liste</a>
  <a href="{{ route('dashboard') }}" style="color: white;">Dashboard</a>
  <a href=""></a>
</div>
  
<div class="wrapper">
  {{-- Description du board --}}

  {{-- === KANBAN === --}}
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
            data-card-id="{{ $card->id }}"
            data-title="{{ $card->title }}"
            data-description="{{ $card->description }}"
            data-category="{{ $card->category }}"
            data-priority="{{ $card->priority }}"
            data-due-date="{{ $card->due_date }}"
            data-assigned-to="{{ $card->assigned_to }}">

              <strong>Titre : {{ $card->title }}</strong>
              <p>Priorité : {{ $card->priority ?? 'pas de priorité.' }}</p>
              <p>Date limite : {{ $card->due_date ?? 'pas de limite.' }}</p>
              <p>Assigné à : 👤 {{ $card->assignedTo?->name ?? 'Non assigné' }}</p>
              <p>Créé par : 👤 {{ $card->createdBy?->name ?? 'Pas de créateur' }}</p>


            </div>
          @endforeach
        </div>

        <button class="open-modal-button" onclick="openCardModal({{ $list->id }})">
          + Ajouter une carte
        </button>
      </div>

      {{-- === MODAL MODIFIER CARTE === --}}
<div class="modal" id="editCardModal">
  <div class="modal-content">
    <span class="close-modal" onclick="closeEditCardModal()">&times;</span>
    <h3>Modifier la carte</h3>
    <form id="editCardForm" method="POST">
      @csrf
      @method('PATCH')

      <input type="text" name="title" id="editTitle" required>
      <textarea name="description" id="editDescription"></textarea>

      <input type="text" name="category" id="editCategory" placeholder="Catégorie (ex : Dev)">

      <select name="priority" id="editPriority">
        <option value="">Priorité</option>
        <option value="basse">Basse</option>
        <option value="moyenne">Moyenne</option>
        <option value="élevée">Élevée</option>
      </select>

      <label>Date limite</label>
      <input type="date" name="due_date" id="editDueDate">

      <label>Attribuer à</label>
      <select name="assigned_to" id="editAssignedTo">
        <option value="">-- Choisir un membre --</option>
        @foreach($board->users as $user)
          <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
      </select>

      <button type="submit">Sauvegarder</button>
    </form>
  </div>
</div>

    @empty
      <p>Aucune colonne trouvée. Créez-en une !</p>
    @endforelse

    {{-- Bouton pour ajouter une nouvelle liste --}}
    <div class="add-list" onclick="openListModal()">
      + Ajoutez une autre liste
    </div>
  </div>
</div>

{{-- === MODAL AJOUT CARTE === --}}
<div class="modal" id="cardModal">
  <div class="modal-content">
    <span class="close-modal" onclick="closeCardModal()">&times;</span>
    <h3>Ajouter une carte</h3>
    <form id="cardForm" method="POST">
      @csrf

      <input type="text" name="title" placeholder="Titre de la carte" required>

      <textarea name="description" placeholder="Description (facultatif)"></textarea>

      <input type="text" name="category" placeholder="Catégorie (ex : Développement, Design)">

      <select name="priority">
        <option value="">Priorité</option>
        <option value="basse">Basse</option>
        <option value="moyenne">Moyenne</option>
        <option value="élevée">Élevée</option>
      </select>

      <label for="due_date">Date limite</label>
      <input type="date" name="due_date">

      <label for="assigned_to">Attribuer à</label>
      <select name="assigned_to" required>
        <option value="">-- Choisir un membre --</option>
        @foreach($board->users as $user)
          <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
      </select>

      <input type="hidden" name="list_id" id="cardListId">

      <button type="submit">Créer</button>
    </form>
  </div>
</div>

<!-- === MODALE INVITATION === -->
<div class="modal" id="inviteModal">
  <div class="modal-content">
    <span class="close-modal" onclick="closeInviteModal()">&times;</span>
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
  </div>
</div>




{{-- === MODAL AJOUT LISTE === --}}
<div class="modal" id="listModal">
  <div class="modal-content">
    <span class="close-modal" onclick="closeListModal()">&times;</span>
    <h3>Ajouter une liste</h3>
    <form id="listForm" action="{{ route('lists.store', $board) }}" method="POST">
      @csrf
      <input type="text" name="title" placeholder="Titre de la liste" required>
      <button type="submit">Créer</button>
    </form>
  </div>
</div>

{{-- === SCRIPTS === --}}
<script>
  // Drag & Drop
  function allowDrop(ev){ ev.preventDefault(); }
  function drag(ev){ ev.dataTransfer.setData("text", ev.target.id); }
  function drop(ev){
    ev.preventDefault();
    let cardId = ev.dataTransfer.getData("text"),
        cardEl = document.getElementById(cardId),
        target = ev.target.closest('.list');
    if(!target) return;
    if(target.dataset.terminal==='true' && !confirm("Cette colonne termine la tâche ?")) return;
    target.querySelector('.card-container').appendChild(cardEl);
    fetch(`/cards/${cardEl.dataset.cardId}/move`, {
      method:'POST',
      headers:{
        'Content-Type':'application/json',
        'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content
      },
      body:JSON.stringify({ list_id: target.dataset.listId })
    }).then(r=>{ if(!r.ok) alert('Erreur de déplacement !'); });
  }

  // Modal Carte
  const cardModal = document.getElementById('cardModal'),
        cardForm  = document.getElementById('cardForm');
  function openCardModal(listId){
    cardForm.action = `/lists/${listId}/cards`;
    cardModal.style.display = 'flex';
  }
  function closeCardModal(){
    cardModal.style.display = 'none';
    cardForm.reset();
  }

  // Modal Liste
  const listModal = document.getElementById('listModal');
  function openListModal(){ listModal.style.display = 'flex'; }
  function closeListModal(){
    listModal.style.display = 'none';
    document.getElementById('listForm').reset();
  }

  // Fermer au clic extérieur
  window.onclick = e=>{
    if(e.target===cardModal) closeCardModal();
    if(e.target===listModal) closeListModal();
  }

  const editCardModal = document.getElementById('editCardModal');
const editCardForm = document.getElementById('editCardForm');

function openEditCardModal(card) {
  // Préremplir le formulaire
  editCardForm.action = `/cards/${card.id}`;
  document.getElementById('editTitle').value = card.title || '';
  document.getElementById('editDescription').value = card.description || '';
  document.getElementById('editCategory').value = card.category || '';
  document.getElementById('editPriority').value = card.priority || '';
  document.getElementById('editDueDate').value = card.due_date || '';
  document.getElementById('editAssignedTo').value = card.assigned_to || '';

  // Afficher le modal
  editCardModal.style.display = 'flex';
}

function closeEditCardModal() {
  editCardModal.style.display = 'none';
  editCardForm.reset();
}

// Gérer le clic sur une carte pour ouvrir la modification
document.querySelectorAll('.card').forEach(cardEl => {
  cardEl.addEventListener('click', () => {
    const card = {
      id: cardEl.dataset.cardId,
      title: cardEl.dataset.title,
      description: cardEl.dataset.description,
      category: cardEl.dataset.category,
      priority: cardEl.dataset.priority,
      due_date: cardEl.dataset.dueDate,
      assigned_to: cardEl.dataset.assignedTo,
    };
    openEditCardModal(card);
  });
});

// Fermer si clic en dehors
window.onclick = e => {
  if (e.target === editCardModal) closeEditCardModal();
};

const inviteModal = document.getElementById('inviteModal');

function openInviteModal() {
  inviteModal.style.display = 'flex';
}

function closeInviteModal() {
  inviteModal.style.display = 'none';
}

// Fermer si clic à l’extérieur
window.onclick = (e) => {
  if (e.target === inviteModal) closeInviteModal();
};


</script>
@endsection
