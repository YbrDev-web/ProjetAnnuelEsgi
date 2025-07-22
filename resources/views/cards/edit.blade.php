@extends('layouts.app')

@section('content')
<div class="wrapper">
  <h2>✏️ Modifier la tâche</h2>

  <form method="POST" action="{{ route('cards.update', $card) }}">
    @csrf
    @method('PATCH')
    <!-- champs -->
</form>
<label>Titre</label>
    <input type="text" name="title" value="{{ $card->title }}" required>

    <label>Description</label>
    <textarea name="description">{{ $card->description }}</textarea>

    <button type="submit">💾 Enregistrer</button>
</div>
@endsection
