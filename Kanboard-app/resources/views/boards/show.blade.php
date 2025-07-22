@php($hideNavigation = true)
@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* Variables de couleurs ProjectFlow */
    :root {
        --pf-primary: #6366f1;
        --pf-primary-dark: #4f46e5;
        --pf-primary-light: #818cf8;
        --pf-dark: #0f172a;
        --pf-dark-secondary: #1e293b;
        --pf-dark-tertiary: #334155;
        --pf-text-light: #f1f5f9;
        --pf-text-muted: #94a3b8;
        --pf-accent: #f472b6;
        --pf-success: #10b981;
        --pf-warning: #f59e0b;
        --pf-danger: #ef4444;
    }

    /* Reset et base */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        background-color: var(--pf-dark);
        color: var(--pf-text-light);
        overflow-x: hidden;
    }

    /* Header moderne */
    .board-header {
        background: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 20px 0;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .header-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .board-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 24px;
        font-weight: 700;
        color: var(--pf-text-light);
    }

    .board-title i {
        font-size: 20px;
        color: var(--pf-primary);
    }

    .header-actions {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        font-weight: 500;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: var(--pf-primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--pf-primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: var(--pf-text-light);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.3);
    }

    /* Navigation tabs */
    .nav-tabs {
        background: var(--pf-dark-secondary);
        padding: 8px;
        display: flex;
        gap: 4px;
        max-width: 1400px;
        margin: 0 auto 24px;
        border-radius: 12px;
        width: calc(100% - 48px);
        margin-left: 24px;
        margin-right: 24px;
        margin-top: 24px;
    }

    .nav-tab {
        flex: 1;
        padding: 12px 24px;
        background: transparent;
        color: var(--pf-text-muted);
        border: none;
        border-radius: 8px;
        text-decoration: none;
        text-align: center;
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .nav-tab:hover {
        background: rgba(255, 255, 255, 0.05);
        color: var(--pf-text-light);
    }

    .nav-tab.active {
        background: var(--pf-primary);
        color: white;
    }

    /* Kanban board container */
    .kanban-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 24px 24px;
    }

    .kanban-board {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        padding-bottom: 20px;
    }

    /* Scrollbar personnalisée */
    .kanban-board::-webkit-scrollbar {
        height: 8px;
    }

    .kanban-board::-webkit-scrollbar-track {
        background: var(--pf-dark-secondary);
        border-radius: 4px;
    }

    .kanban-board::-webkit-scrollbar-thumb {
        background: var(--pf-dark-tertiary);
        border-radius: 4px;
    }

    .kanban-board::-webkit-scrollbar-thumb:hover {
        background: var(--pf-primary);
    }

    /* Colonnes Kanban */
    .list {
        background: var(--pf-dark-secondary);
        border-radius: 12px;
        min-width: 320px;
        max-width: 320px;
        padding: 16px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }

    .list:hover {
        border-color: rgba(99, 102, 241, 0.3);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .list h3 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 16px;
        color: var(--pf-text-light);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .list-count {
        background: rgba(255, 255, 255, 0.1);
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 400;
        color: var(--pf-text-muted);
    }

    /* Zone de drop */
    .card-container {
        min-height: 60px;
        transition: all 0.3s ease;
        border-radius: 8px;
        padding: 4px;
    }

    .card-container.drag-over {
        background: rgba(99, 102, 241, 0.1);
        border: 2px dashed var(--pf-primary);
    }

    /* Cartes */
    .card {
        background: var(--pf-dark);
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 12px;
        cursor: grab;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        border-color: rgba(99, 102, 241, 0.3);
    }

    .card.dragging {
        opacity: 0.5;
        cursor: grabbing;
    }

    .card-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--pf-text-light);
    }

    .card-meta {
        display: flex;
        flex-direction: column;
        gap: 6px;
        font-size: 13px;
        color: var(--pf-text-muted);
    }

    .card-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .card-meta-item i {
        font-size: 12px;
        width: 16px;
        text-align: center;
    }

    /* Badges de priorité */
    .priority-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .priority-élevée {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }

    .priority-moyenne {
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
    }

    .priority-basse {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
    }

    /* Bouton ajouter carte */
    .add-card-btn {
        width: 100%;
        padding: 12px;
        background: rgba(255, 255, 255, 0.05);
        border: 2px dashed rgba(255, 255, 255, 0.2);
        color: var(--pf-text-muted);
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 12px;
    }

    .add-card-btn:hover {
        background: rgba(99, 102, 241, 0.1);
        border-color: var(--pf-primary);
        color: var(--pf-primary);
    }

    /* Bouton ajouter liste */
    .add-list {
        min-width: 320px;
        max-width: 320px;
        background: rgba(255, 255, 255, 0.05);
        border: 2px dashed rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--pf-text-muted);
        font-weight: 500;
    }

    .add-list:hover {
        background: rgba(99, 102, 241, 0.1);
        border-color: var(--pf-primary);
        color: var(--pf-primary);
    }

    /* Modals */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(4px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: var(--pf-dark-secondary);
        border-radius: 16px;
        padding: 32px;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .modal-header h3 {
        font-size: 20px;
        font-weight: 600;
        color: var(--pf-text-light);
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 24px;
        color: var(--pf-text-muted);
        cursor: pointer;
        transition: color 0.3s ease;
        padding: 4px;
    }

    .close-modal:hover {
        color: var(--pf-text-light);
    }

    /* Formulaires */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--pf-text-light);
        font-size: 14px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px 16px;
        background: var(--pf-dark);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        color: var(--pf-text-light);
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--pf-primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    /* Animation de chargement */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .list {
        animation: fadeIn 0.5s ease-out;
    }

    .card {
        animation: fadeIn 0.3s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-container {
            flex-direction: column;
            gap: 16px;
        }

        .nav-tabs {
            flex-direction: column;
        }

        .list {
            min-width: 280px;
            max-width: 280px;
        }

        .add-list {
            min-width: 280px;
            max-width: 280px;
        }
    }
</style>

{{-- Header moderne --}}
<div class="board-header">
    <div class="header-container">
        <div class="board-title">
            <i class="fa fa-layer-group"></i>
            {{ $board->name }}
        </div>
        <div class="header-actions">
            @if($board->user_id === auth()->id())
                <button class="btn btn-secondary" onclick="openInviteModal()">
                    <i class="fa fa-user-plus"></i>
                    Partager
                </button>
            @endif
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i>
                Retour
            </a>
        </div>
    </div>
</div>

{{-- Navigation tabs --}}
<div class="nav-tabs">
    <a href="{{ route('boards.show', $board) }}" class="nav-tab active">
        <i class="fa fa-columns"></i>
        Kanban
    </a>
    <a href="{{ route('cards.list', $board) }}" class="nav-tab">
        <i class="fa fa-list"></i>
        Liste
    </a>
    <a href="{{ route('boards.calendar', $board) }}" class="nav-tab">
        <i class="fa fa-calendar"></i>
        Calendrier
    </a>
</div>

{{-- Kanban Board --}}
<div class="kanban-container">
    <div class="kanban-board">
        @forelse($board->lists as $list)
            <div class="list" data-list-id="{{ $list->id }}" data-terminal="{{ $list->is_terminal ? 'true' : 'false' }}">
                <h3>
                    {{ $list->title }}
                    <span class="list-count">{{ $list->cards->count() }}</span>
                </h3>

                <div class="card-container" ondrop="drop(event)" ondragover="allowDrop(event)" ondragleave="dragLeave(event)">
                    @foreach($list->cards as $card)
                        <div class="card"
                            draggable="true"
                            ondragstart="drag(event)"
                            ondragend="dragEnd(event)"
                            id="card-{{ $card->id }}"
                            data-card-id="{{ $card->id }}"
                            data-title="{{ $card->title }}"
                            data-description="{{ $card->description }}"
                            data-category="{{ $card->category }}"
                            data-priority="{{ $card->priority }}"
                            data-due-date="{{ $card->due_date }}"
                            data-assigned-to="{{ $card->assigned_to }}"
                            onclick="openEditCardModal(this)">

                            <div class="card-title">{{ $card->title }}</div>
                            
                            <div class="card-meta">
                                @if($card->priority)
                                    <div class="card-meta-item">
                                        <span class="priority-badge priority-{{ $card->priority }}">
                                            {{ $card->priority }}
                                        </span>
                                    </div>
                                @endif

                                @if($card->due_date)
                                    <div class="card-meta-item">
                                        <i class="fa fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($card->due_date)->format('d M Y') }}
                                    </div>
                                @endif

                                @if($card->assignedTo)
                                    <div class="card-meta-item">
                                        <i class="fa fa-user"></i>
                                        {{ $card->assignedTo->name }}
                                    </div>
                                @endif

                                @if($card->category)
                                    <div class="card-meta-item">
                                        <i class="fa fa-tag"></i>
                                        {{ $card->category }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <button class="add-card-btn" onclick="openCardModal({{ $list->id }})">
                    <i class="fa fa-plus"></i> Ajouter une carte
                </button>
            </div>
        @empty
            <p style="color: var(--pf-text-muted);">Aucune liste trouvée. Créez-en une pour commencer !</p>
        @endforelse

        <div class="add-list" onclick="openListModal()">
            <i class="fa fa-plus"></i> Ajouter une liste
        </div>
    </div>
</div>

{{-- Modal Ajouter Carte --}}
<div class="modal" id="cardModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Ajouter une carte</h3>
            <button class="close-modal" onclick="closeCardModal()">&times;</button>
        </div>
        <form id="cardForm" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" placeholder="Titre de la carte" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" placeholder="Description (facultatif)"></textarea>
            </div>

            <div class="form-group">
                <label for="category">Catégorie</label>
                <input type="text" name="category" id="category" placeholder="Ex : Développement, Design">
            </div>

            <div class="form-group">
                <label for="priority">Priorité</label>
                <select name="priority" id="priority">
                    <option value="">Sélectionner une priorité</option>
                    <option value="basse">Basse</option>
                    <option value="moyenne">Moyenne</option>
                    <option value="élevée">Élevée</option>
                </select>
            </div>

            <div class="form-group">
                <label for="due_date">Date limite</label>
                <input type="date" name="due_date" id="due_date">
            </div>

            <div class="form-group">
                <label for="assigned_to">Attribuer à</label>
                <select name="assigned_to" id="assigned_to" required>
                    <option value="">Choisir un membre</option>
                    @foreach($board->users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <input type="hidden" name="list_id" id="cardListId">

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 12px;">
                <i class="fa fa-plus"></i> Créer la carte
            </button>
        </form>
    </div>
</div>

{{-- Modal Modifier Carte --}}
<div class="modal" id="editCardModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Modifier la carte</h3>
            <button class="close-modal" onclick="closeEditCardModal()">&times;</button>
        </div>
        <form id="editCardForm" method="POST">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="editTitle">Titre</label>
                <input type="text" name="title" id="editTitle" required>
            </div>

            <div class="form-group">
                <label for="editDescription">Description</label>
                <textarea name="description" id="editDescription"></textarea>
            </div>

            <div class="form-group">
                <label for="editCategory">Catégorie</label>
                <input type="text" name="category" id="editCategory" placeholder="Ex : Dev">
            </div>

            <div class="form-group">
                <label for="editPriority">Priorité</label>
                <select name="priority" id="editPriority">
                    <option value="">Sélectionner une priorité</option>
                    <option value="basse">Basse</option>
                    <option value="moyenne">Moyenne</option>
                    <option value="élevée">Élevée</option>
                </select>
            </div>

            <div class="form-group">
                <label for="editDueDate">Date limite</label>
                <input type="date" name="due_date" id="editDueDate">
            </div>

            <div class="form-group">
                <label for="editAssignedTo">Attribuer à</label>
                <select name="assigned_to" id="editAssignedTo">
                    <option value="">Choisir un membre</option>
                    @foreach($board->users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 12px;">
                <i class="fa fa-save"></i> Sauvegarder
            </button>
        </form>
    </div>
</div>

{{-- Modal Invitation --}}
<div class="modal" id="inviteModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Inviter un membre</h3>
            <button class="close-modal" onclick="closeInviteModal()">&times;</button>
        </div>
        <form action="{{ route('boards.members.invite', $board) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email de l'utilisateur</label>
                <input type="email" name="email" id="email" placeholder="email@exemple.com" required>
            </div>

            <div class="form-group">
                <label for="role">Rôle</label>
                <select name="role" id="role" required>
                    <option value="member">Membre</option>
                    <option value="admin">Admin</option>
                    <option value="viewer">Lecteur</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 12px;">
                <i class="fa fa-send"></i> Envoyer l'invitation
            </button>
        </form>
    </div>
</div>

{{-- Modal Ajouter Liste --}}
<div class="modal" id="listModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Ajouter une liste</h3>
            <button class="close-modal" onclick="closeListModal()">&times;</button>
        </div>
        <form id="listForm" action="{{ route('lists.store', $board) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="listTitle">Titre de la liste</label>
                <input type="text" name="title" id="listTitle" placeholder="Ex : À faire" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 12px;">
                <i class="fa fa-plus"></i> Créer la liste
            </button>
        </form>
    </div>
</div>

{{-- Scripts améliorés --}}
<script>
    // Drag & Drop amélioré
    function allowDrop(ev) {
        ev.preventDefault();
        ev.currentTarget.classList.add('drag-over');
    }

    function dragLeave(ev) {
        ev.currentTarget.classList.remove('drag-over');
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
        ev.target.classList.add('dragging');
    }

    function dragEnd(ev) {
        ev.target.classList.remove('dragging');
        document.querySelectorAll('.card-container').forEach(container => {
            container.classList.remove('drag-over');
        });
    }

    function drop(ev) {
        ev.preventDefault();
        ev.currentTarget.classList.remove('drag-over');
        
        let cardId = ev.dataTransfer.getData("text");
        let cardEl = document.getElementById(cardId);
        let target = ev.target.closest('.list');
        
        if (!target) return;
        
        if (target.dataset.terminal === 'true' && !confirm("Cette colonne termine la tâche. Êtes-vous sûr ?")) {
            return;
        }
        
        target.querySelector('.card-container').appendChild(cardEl);
        updateListCounts();
        
        // Mise à jour en base de données
        fetch(`/cards/${cardEl.dataset.cardId}/move`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ list_id: target.dataset.listId })
        }).then(response => {
            if (!response.ok) {
                console.error('Erreur de déplacement');
            }
        });
    }

    function updateListCounts() {
        document.querySelectorAll('.list').forEach(list => {
            const count = list.querySelectorAll('.card').length;
            const countEl = list.querySelector('.list-count');
            if (countEl) {
                countEl.textContent = count;
            }
        });
    }

    // Gestion des modals
    const modals = {
        card: document.getElementById('cardModal'),
        editCard: document.getElementById('editCardModal'),
        list: document.getElementById('listModal'),
        invite: document.getElementById('inviteModal')
    };

    function openCardModal(listId) {
        document.getElementById('cardForm').action = `/lists/${listId}/cards`;
        modals.card.style.display = 'flex';
    }

    function closeCardModal() {
        modals.card.style.display = 'none';
        document.getElementById('cardForm').reset();
    }

    function openEditCardModal(cardElement) {
        const card = {
            id: cardElement.dataset.cardId,
            title: cardElement.dataset.title,
            description: cardElement.dataset.description,
            category: cardElement.dataset.category,
            priority: cardElement.dataset.priority,
            due_date: cardElement.dataset.dueDate,
            assigned_to: cardElement.dataset.assignedTo,
        };
        
        document.getElementById('editCardForm').action = `/cards/${card.id}`;
        document.getElementById('editTitle').value = card.title || '';
        document.getElementById('editDescription').value = card.description || '';
        document.getElementById('editCategory').value = card.category || '';
        document.getElementById('editPriority').value = card.priority || '';
        document.getElementById('editDueDate').value = card.due_date || '';
        document.getElementById('editAssignedTo').value = card.assigned_to || '';

        modals.editCard.style.display = 'flex';
    }

    function closeEditCardModal() {
        modals.editCard.style.display = 'none';
        document.getElementById('editCardForm').reset();
    }

    function openListModal() {
        modals.list.style.display = 'flex';
    }

    function closeListModal() {
        modals.list.style.display = 'none';
        document.getElementById('listForm').reset();
    }

    function openInviteModal() {
        modals.invite.style.display = 'flex';
    }

    function closeInviteModal() {
        modals.invite.style.display = 'none';
    }

    // Fermeture des modals au clic extérieur
    window.onclick = function(event) {
        Object.entries(modals).forEach(([key, modal]) => {
            if (event.target === modal) {
                modal.style.display = 'none';
                modal.querySelector('form')?.reset();
            }
        });
    }

    // Raccourcis clavier
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            Object.values(modals).forEach(modal => {
                modal.style.display = 'none';
            });
        }
    });

    // Animation d'apparition des cartes
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    });

    document.querySelectorAll('.card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.3s ease';
        observer.observe(card);
    });

    // Notification toast
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.style.cssText = `
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: ${type === 'success' ? 'var(--pf-success)' : 'var(--pf-danger)'};
            color: white;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            font-weight: 500;
            z-index: 1100;
            animation: slideInRight 0.3s ease;
        `;
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Animations CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

    // Initialisation
    updateListCounts();
</script>
@endsection