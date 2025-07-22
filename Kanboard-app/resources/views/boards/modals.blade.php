{{-- resources/views/boards/modals.blade.php --}}

{{-- Modal Ajout Carte --}}
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

{{-- Modal Modifier Carte --}}
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

{{-- Modal Invitation --}}
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

{{-- Modal Ajout Liste --}}
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

<script>
// Fonctions de gestion des modals existantes
function openCardModal(listId) {
    document.getElementById('cardForm').action = `/lists/${listId}/cards`;
    document.getElementById('cardModal').style.display = 'flex';
}

function closeCardModal() {
    document.getElementById('cardModal').style.display = 'none';
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

    document.getElementById('editCardModal').style.display = 'flex';
}

function closeEditCardModal() {
    document.getElementById('editCardModal').style.display = 'none';
    document.getElementById('editCardForm').reset();
}

function openListModal() {
    document.getElementById('listModal').style.display = 'flex';
}

function closeListModal() {
    document.getElementById('listModal').style.display = 'none';
    document.getElementById('listForm').reset();
}

function openInviteModal() {
    document.getElementById('inviteModal').style.display = 'flex';
}

function closeInviteModal() {
    document.getElementById('inviteModal').style.display = 'none';
}
</script>