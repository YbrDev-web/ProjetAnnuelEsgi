@php($hideNavigation = true)
@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- CSS FullCalendar et Interactions --}}
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<style>
    .calendar-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background: var(--bg-primary);
        min-height: 100vh;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 20px;
        background: var(--bg-secondary);
        border-radius: 8px;
    }

    .calendar-title {
        font-size: 24px;
        font-weight: bold;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .calendar-actions {
        display: flex;
        gap: 10px;
    }

    .calendar-actions a, .calendar-actions button {
        padding: 8px 16px;
        background: var(--accent-primary);
        color: white;
        text-decoration: none;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        transition: background 0.2s;
    }

    .calendar-actions a:hover, .calendar-actions button:hover {
        background: var(--accent-hover);
    }

    #calendar {
        background: var(--bg-card);
        padding: 20px;
        border-radius: 8px;
        box-shadow: var(--shadow-md);
    }

    /* Style pour les boutons de vue */
    .fc-button-group button {
        background: var(--accent-primary) !important;
        border: none !important;
        color: white !important;
    }

    .fc-button-active {
        background: var(--accent-hover) !important;
    }

    .fc-button:hover {
        background: var(--accent-hover) !important;
    }

    /* Style pour les événements */
    .fc-event {
        cursor: move;
        padding: 2px 4px;
        border-radius: 4px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .fc-event:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .fc-event-dragging {
        opacity: 0.75;
        z-index: 999 !important;
    }

    .fc-event-title {
        font-weight: 500;
    }

    /* Indicateur de drop */
    .fc-highlight {
        background: rgba(59, 130, 246, 0.15) !important;
        border: 2px dashed var(--accent-primary) !important;
    }

    /* Style pour les jours */
    .fc-daygrid-day:hover {
        background-color: var(--bg-tertiary);
        cursor: pointer;
    }

    .fc-day-today {
        background-color: rgba(59, 130, 246, 0.1) !important;
    }

    /* Modal pour les détails et création */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background: var(--bg-modal);
        padding: 30px;
        border-radius: 8px;
        max-width: 500px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
        color: var(--text-primary);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .modal-close {
        font-size: 28px;
        cursor: pointer;
        color: var(--text-tertiary);
    }

    .modal-close:hover {
        color: var(--text-primary);
    }

    .event-details {
        margin-top: 20px;
    }

    .event-detail-row {
        display: flex;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border-primary);
    }

    .event-detail-label {
        font-weight: bold;
        width: 120px;
        color: var(--text-secondary);
    }

    .event-detail-value {
        flex: 1;
    }

    .priority-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 16px;
        color: white;
        font-size: 12px;
        font-weight: bold;
    }

    .priority-élevée { background: #dc2626; }
    .priority-moyenne { background: #f59e0b; }
    .priority-basse { background: #10b981; }

    /* Formulaire dans modal */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: var(--text-primary);
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid var(--border-primary);
        border-radius: 4px;
        background: var(--bg-secondary);
        color: var(--text-primary);
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--accent-primary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-primary {
        background: var(--accent-primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--accent-hover);
    }

    .btn-secondary {
        background: var(--bg-tertiary);
        color: var(--text-primary);
    }

    .btn-secondary:hover {
        background: var(--bg-secondary);
    }

    /* Notification toast */
    .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: var(--bg-secondary);
        color: var(--text-primary);
        padding: 16px 24px;
        border-radius: 8px;
        box-shadow: var(--shadow-lg);
        display: none;
        align-items: center;
        gap: 10px;
        z-index: 1001;
    }

    .toast.show {
        display: flex;
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .toast.success {
        border-left: 4px solid var(--accent-success);
    }

    .toast.error {
        border-left: 4px solid var(--accent-danger);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .calendar-header {
            flex-direction: column;
            gap: 15px;
        }

        .calendar-actions {
            width: 100%;
            justify-content: center;
            flex-wrap: wrap;
        }

        #calendar {
            padding: 10px;
        }

        .fc-toolbar {
            flex-direction: column;
            gap: 10px;
        }

        .fc-toolbar-chunk {
            display: flex;
            justify-content: center;
        }
    }
</style>

{{-- Header --}}
<div class="calendar-container">
    <div class="calendar-header">
        <div class="calendar-title">
            <i class="fa fa-calendar"></i>
            Calendrier - {{ $board->name }}
        </div>
        <div class="calendar-actions">
            <button onclick="showCreateModal()" class="btn-create">
                <i class="fa fa-plus"></i> Nouvelle tâche
            </button>
            <a href="{{ route('boards.show', $board) }}">Vue Kanban</a>
            <a href="{{ route('cards.list', $board) }}">Vue Liste</a>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
    </div>

    {{-- Calendrier --}}
    <div id="calendar"></div>
</div>

{{-- Modal pour afficher les détails d'une tâche --}}
<div class="modal" id="eventModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="eventTitle"></h3>
            <span class="modal-close" onclick="closeEventModal()">&times;</span>
        </div>
        <div class="event-details">
            <div class="event-detail-row">
                <span class="event-detail-label">Description:</span>
                <span class="event-detail-value" id="eventDescription">-</span>
            </div>
            <div class="event-detail-row">
                <span class="event-detail-label">Catégorie:</span>
                <span class="event-detail-value" id="eventCategory">-</span>
            </div>
            <div class="event-detail-row">
                <span class="event-detail-label">Priorité:</span>
                <span class="event-detail-value" id="eventPriority">-</span>
            </div>
            <div class="event-detail-row">
                <span class="event-detail-label">Liste:</span>
                <span class="event-detail-value" id="eventList">-</span>
            </div>
            <div class="event-detail-row">
                <span class="event-detail-label">Date limite:</span>
                <span class="event-detail-value" id="eventDueDate">-</span>
            </div>
            <div class="event-detail-row">
                <span class="event-detail-label">Assigné à:</span>
                <span class="event-detail-value" id="eventAssignedTo">-</span>
            </div>
            <div class="event-detail-row">
                <span class="event-detail-label">Créé par:</span>
                <span class="event-detail-value" id="eventCreatedBy">-</span>
            </div>
        </div>
        <div class="form-actions">
            <a href="#" id="editCardLink" class="btn btn-primary">Modifier</a>
        </div>
    </div>
</div>

{{-- Modal pour créer une nouvelle tâche --}}
<div class="modal" id="createModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Créer une nouvelle tâche</h3>
            <span class="modal-close" onclick="closeCreateModal()">&times;</span>
        </div>
        <form id="createCardForm" onsubmit="createCard(event)">
            <div class="form-group">
                <label for="newTitle">Titre *</label>
                <input type="text" id="newTitle" name="title" required>
            </div>
            
            <div class="form-group">
                <label for="newDescription">Description</label>
                <textarea id="newDescription" name="description" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label for="newCategory">Catégorie</label>
                <input type="text" id="newCategory" name="category" placeholder="Ex: Développement">
            </div>
            
            <div class="form-group">
                <label for="newPriority">Priorité</label>
                <select id="newPriority" name="priority">
                    <option value="">-- Choisir --</option>
                    <option value="basse">Basse</option>
                    <option value="moyenne">Moyenne</option>
                    <option value="élevée">Élevée</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="newDueDate">Date limite *</label>
                <input type="date" id="newDueDate" name="due_date" required>
            </div>
            
            <div class="form-group">
                <label for="newList">Liste *</label>
                <select id="newList" name="list_id" required>
                    <option value="">-- Choisir une liste --</option>
                    @foreach($board->lists as $list)
                        <option value="{{ $list->id }}">{{ $list->title }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="newAssignedTo">Assigner à</label>
                <select id="newAssignedTo" name="assigned_to">
                    <option value="">-- Choisir un membre --</option>
                    @foreach($board->users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeCreateModal()">Annuler</button>
                <button type="submit" class="btn btn-primary">Créer la tâche</button>
            </div>
        </form>
    </div>
</div>

{{-- Toast de notification --}}
<div class="toast" id="toast">
    <i class="fa fa-check-circle"></i>
    <span id="toastMessage">Modification enregistrée</span>
</div>

{{-- Scripts FullCalendar et interactions --}}
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/fr.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@5.11.3/main.min.js'></script>
<script>
// Variables globales
let calendar;
let selectedDate = null;
const boardId = {{ $board->id }};

document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    
    // Données des cartes
    const events = @json($cards);
    
    // Initialiser FullCalendar avec drag & drop
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        height: 'auto',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek,timeGridWeek,timeGridDay,listWeek'
        },
        buttonText: {
            today: "Aujourd'hui",
            month: 'Mois',
            week: 'Semaine',
            day: 'Jour',
            list: 'Liste'
        },
        views: {
            dayGridWeek: {
                buttonText: '7 jours'
            },
            timeGridWeek: {
                buttonText: 'Semaine (heures)'
            },
            timeGridThreeDay: {
                type: 'timeGrid',
                duration: { days: 3 },
                buttonText: '3 jours'
            }
        },
        events: events,
        
        // Configuration du drag & drop
        editable: true,
        droppable: true,
        eventDurationEditable: true,
        eventResizableFromStart: true,
        
        // Événements du calendrier
        eventClick: function(info) {
            showEventDetails(info.event);
        },
        
        // Drag & Drop
        eventDrop: function(info) {
            updateCardDate(info.event, info.revert);
        },
        
        // Redimensionnement (étirement)
        eventResize: function(info) {
            updateCardDuration(info.event, info.revert);
        },
        
        // Clic sur une date vide
        dateClick: function(info) {
            selectedDate = info.dateStr;
            document.getElementById('newDueDate').value = selectedDate;
            showCreateModal();
        },
        
        // Sélection de plage de dates
        selectable: true,
        select: function(info) {
            selectedDate = info.startStr;
            document.getElementById('newDueDate').value = selectedDate;
            showCreateModal();
        },
        
        // Style au survol
        eventMouseEnter: function(info) {
            info.el.style.transform = 'scale(1.05)';
            info.el.style.zIndex = '999';
        },
        
        eventMouseLeave: function(info) {
            info.el.style.transform = 'scale(1)';
            info.el.style.zIndex = 'auto';
        },
        
        // Configuration supplémentaire
        dayMaxEvents: true,
        moreLinkClick: 'popover',
        eventDisplay: 'block'
    });
    
    calendar.render();
    
    // Ajouter la vue 3 jours
    addThreeDayButton();
});

// Ajouter le bouton 3 jours
function addThreeDayButton() {
    const toolbar = document.querySelector('.fc-toolbar-chunk:last-child');
    if (toolbar) {
        const threeDayBtn = document.createElement('button');
        threeDayBtn.className = 'fc-button fc-button-primary';
        threeDayBtn.textContent = '3 jours';
        threeDayBtn.onclick = function() {
            calendar.changeView('timeGridThreeDay');
        };
        toolbar.insertBefore(threeDayBtn, toolbar.children[3]);
    }
}

// Mettre à jour la date d'une carte après drag & drop
function updateCardDate(event, revert) {
    const cardId = event.id;
    const newDate = event.startStr;
    
    // Confirmation si changement important
    const oldDate = new Date(event.extendedProps.originalDate || event.start);
    const daysDiff = Math.abs((event.start - oldDate) / (1000 * 60 * 60 * 24));
    
    if (daysDiff > 7) {
        if (!confirm(`Êtes-vous sûr de vouloir déplacer cette tâche de ${Math.round(daysDiff)} jours ?`)) {
            revert();
            return;
        }
    }
    
    // Envoyer la mise à jour au serveur
    fetch(`/cards/${cardId}/update-date`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            due_date: newDate
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Date mise à jour avec succès', 'success');
        } else {
            revert();
            showToast('Erreur lors de la mise à jour', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        revert();
        showToast('Erreur de connexion', 'error');
    });
}

// Mettre à jour la durée d'une carte (fonctionnalité future)
function updateCardDuration(event, revert) {
    // Pour l'instant, on empêche le redimensionnement
    // car les cartes n'ont qu'une date limite, pas une durée
    revert();
    showToast('Les tâches ne peuvent pas avoir de durée pour le moment', 'error');
}

// Créer une nouvelle carte
function createCard(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());
    
    // Envoyer au serveur
    fetch(`/lists/${data.list_id}/cards/calendar`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Ajouter l'événement au calendrier
            calendar.addEvent({
                id: data.card.id,
                title: data.card.title,
                start: data.card.due_date,
                backgroundColor: getPriorityColor(data.card.priority),
                borderColor: getPriorityColor(data.card.priority),
                extendedProps: {
                    description: data.card.description,
                    category: data.card.category,
                    priority: data.card.priority,
                    list_title: data.list_title,
                    assigned_to: data.assigned_to_name,
                    created_by: '{{ auth()->user()->name }}'
                }
            });
            
            closeCreateModal();
            showToast('Tâche créée avec succès', 'success');
        } else {
            showToast('Erreur lors de la création', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showToast('Erreur de connexion', 'error');
    });
}

// Obtenir la couleur selon la priorité
function getPriorityColor(priority) {
    const colors = {
        'élevée': '#dc2626',
        'moyenne': '#f59e0b',
        'basse': '#10b981'
    };
    return colors[priority] || '#6b7280';
}

// Afficher les détails d'un événement
function showEventDetails(event) {
    const modal = document.getElementById('eventModal');
    const props = event.extendedProps;
    
    document.getElementById('eventTitle').textContent = event.title;
    document.getElementById('eventDescription').textContent = props.description || '-';
    document.getElementById('eventCategory').textContent = props.category || '-';
    
    // Priorité avec badge
    const priorityEl = document.getElementById('eventPriority');
    if (props.priority) {
        priorityEl.innerHTML = `<span class="priority-badge priority-${props.priority}">${props.priority}</span>`;
    } else {
        priorityEl.textContent = '-';
    }
    
    document.getElementById('eventList').textContent = props.list_title || '-';
    document.getElementById('eventDueDate').textContent = formatDate(event.start);
    document.getElementById('eventAssignedTo').textContent = props.assigned_to || '-';
    document.getElementById('eventCreatedBy').textContent = props.created_by || '-';
    
    // Lien pour éditer
    document.getElementById('editCardLink').href = `/cards/${event.id}/edit`;
    
    modal.style.display = 'flex';
}

// Fonctions de modal
function closeEventModal() {
    document.getElementById('eventModal').style.display = 'none';
}

function showCreateModal() {
    document.getElementById('createModal').style.display = 'flex';
}

function closeCreateModal() {
    document.getElementById('createModal').style.display = 'none';
    document.getElementById('createCardForm').reset();
    selectedDate = null;
}

// Afficher une notification toast
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');
    
    toast.className = `toast ${type}`;
    toastMessage.textContent = message;
    toast.classList.add('show');
    
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}

// Formater la date
function formatDate(date) {
    if (!date) return '-';
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return date.toLocaleDateString('fr-FR', options);
}

// Fermer les modals en cliquant à l'extérieur
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}

// Raccourcis clavier
document.addEventListener('keydown', function(e) {
    // Échap pour fermer les modals
    if (e.key === 'Escape') {
        closeEventModal();
        closeCreateModal();
    }
    
    // Ctrl+N pour nouvelle tâche
    if (e.ctrlKey && e.key === 'n') {
        e.preventDefault();
        showCreateModal();
    }
});
</script>
@endsection