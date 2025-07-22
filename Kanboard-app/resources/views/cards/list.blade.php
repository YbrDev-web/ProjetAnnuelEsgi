@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/cards-list.css') }}">

<div style="padding: 0 15px 15px; display: flex; gap: 10px; margin-top: 20px;">
              <a href="{{ route('dashboard') }}"class="small-button" style="flex: 1; text-align: center;">
                Dashboard
              </a>
              <a href="{{ route('boards.show', $board) }}" class="small-button" style="flex: 1; text-align: center;">
                📋 Kanban
              </a>
              <a href="{{ route('cards.list', $board) }}" class="small-button" style="flex: 1; text-align: center;">
                📝 Liste
              </a>
              <a href="{{ route('boards.calendar', $board) }}" class="small-button" style="flex: 1; text-align: center;">
                📅 Calendrier
              </a>
</div>

<div class="wrapper">
    <h2>📋 Tâches du tableau : {{ $board->name }}</h2>
    <p>{{ $board->description }}</p>

    @if($cards->isEmpty())
        <p>Aucune tâche trouvée pour ce tableau.</p>
    @else
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
                @foreach ($cards as $card)
                    <tr>
                        <td>{{ $card->title }}</td>
                        <td>{{ $card->description ?? '—' }}</td>
                        <td>{{ $card->list->title ?? '—' }}</td>
                        <td>
                            <a href="{{ route('cards.edit', $card) }}">✏️ Modifier</a>
                            <form action="{{ route('cards.destroy', $card) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Supprimer cette tâche ?')" style="color: red;">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('boards.show', $board) }}" class="btn" style="margin-top: 50px;">← Retour au tableau</a>
</div>
@endsection
