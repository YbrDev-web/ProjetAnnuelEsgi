@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/cards-list.css') }}">

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

    <a href="{{ route('boards.show', $board) }}" class="btn" style="margin-top: 20px;">← Retour au tableau</a>
</div>
@endsection
