@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/cards-list.css') }}">

<style>
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
</style>
<div class="nav-tabs">
    <a href="{{ route('dashboard') }}"class="nav-tab ">
      Dashboard
    </a>
    <a href="{{ route('boards.show', $board) }}" class="nav-tab">
        <i class="fa fa-columns"></i>
        Kanban
    </a>
    <a href="{{ route('cards.list', $board) }}" class="nav-tab active">
        <i class="fa fa-list"></i>
        Liste
    </a>
    <a href="{{ route('boards.calendar', $board) }}" class="nav-tab">
        <i class="fa fa-calendar"></i>
        Calendrier
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
