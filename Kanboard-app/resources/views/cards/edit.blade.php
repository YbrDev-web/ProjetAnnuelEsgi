@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/card-edit.css') }}">

<div class="edit-card-container">
    <h2>✏️ Modifier la tâche</h2>

    @if ($errors->any())
        <div class="error-box">
            <strong>Erreurs :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('cards.update', $card) }}">
    @csrf
    @method('PATCH')

    <div class="form-group">
        <label for="title">Titre</label>
        <input type="text" name="title" id="title" value="{{ old('title', $card->title) }}" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" rows="4">{{ old('description', $card->description) }}</textarea>
    </div>

    <div class="form-group">
        <label for="category">Catégorie</label>
        <input type="text" name="category" id="category" value="{{ old('category', $card->category) }}">
    </div>

    <div class="form-group">
        <label for="priority">Priorité</label>
        <select name="priority" id="priority">
            <option value="">—</option>
            <option value="basse" {{ old('priority', $card->priority) === 'basse' ? 'selected' : '' }}>Basse</option>
            <option value="moyenne" {{ old('priority', $card->priority) === 'moyenne' ? 'selected' : '' }}>Moyenne</option>
            <option value="élevée" {{ old('priority', $card->priority) === 'élevée' ? 'selected' : '' }}>Élevée</option>
        </select>
    </div>

    <div class="form-group">
        <label for="due_date">Date limite</label>
        <input type="date" name="due_date" id="due_date" 
       value="{{ old('due_date', \Carbon\Carbon::parse($card->due_date)->format('Y-m-d')) }}">
    </div>

    <div class="form-group">
        <label for="assigned_to">Attribuer à</label>
        <select name="assigned_to" id="assigned_to">
            <option value="">— Aucun —</option>
            @foreach($card->list->board->users as $user)
                <option value="{{ $user->id }}" {{ old('assigned_to', $card->assigned_to) == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-actions" style="margin-top: 20px;">
        <button type="submit">💾 Sauvegarder</button>
        <a href="{{ route('boards.show', $card->list->board_id) }}">← Retour au tableau</a>
    </div>
</form>

</div>
@endsection
