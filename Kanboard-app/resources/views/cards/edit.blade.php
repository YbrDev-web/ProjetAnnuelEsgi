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

        <div class="form-actions">
            <button type="submit">💾 Sauvegarder</button>
            <a href="{{ route('boards.show', $card->list->board_id) }}">← Retour au tableau</a>
        </div>
    </form>
</div>
@endsection
