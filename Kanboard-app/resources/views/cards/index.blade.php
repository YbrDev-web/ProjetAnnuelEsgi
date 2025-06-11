@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/cards-list.css') }}">

@section('content')
<div class="wrapper">
  <h2>📄 Tâches de "{{ $board->name }}"</h2>

  <form method="GET" action="{{ route('cards.index', $board) }}" style="margin-bottom: 20px;">
    <input type="text" name="title" placeholder="Titre" value="{{ request('title') }}">
    <input type="text" name="description" placeholder="Description" value="{{ request('description') }}">
    <button type="submit">🔍 Filtrer</button>
  </form>

  <table class="task-table">
    <thead>
      <tr>
        <th>Titre</th>
        <th>Description</th>
        <th>Colonne</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($cards as $card)
      <tr>
        <td>{{ $card->title }}</td>
        <td>{{ $card->description }}</td>
        <td>{{ $card->list->title ?? '—' }}</td>
        <td>
          <a href="{{ route('cards.edit', $card) }}">✏️ Modifier</a>

          <form action="{{ route('cards.destroy', $card) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Supprimer cette tâche ?')">🗑️ Supprimer</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
