jr242 — 10:43
test
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
Afficher plus
message.txt
29 Ko
jr242 — 11:13
@extends('layouts.app')

@section('content')
<div class="p-6" x-data="{ open: false }">
    <div class="mb-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Calendrier - {{ $project->title }}</h1>
Afficher plus
message.txt
5 Ko
﻿
jr242
jr242
 
@extends('layouts.app')

@section('content')
<div class="p-6" x-data="{ open: false }">
    <div class="mb-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Calendrier - {{ $project->title }}</h1>
        <button @click="open = true"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
            + Nouvelle tâche
        </button>
    </div>

    <!-- Modale de création de tâche -->
    <div x-show="open"
         @click.away="open = false"
         x-transition
         class="fixed inset-0 bg-black bg-opacity-30 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded shadow w-full max-w-md" @click.stop>
            <h2 class="text-lg font-bold mb-4">Nouvelle tâche</h2>
            <form method="POST" action="{{ route('tasks.store', $project->columns->first()) }}">
                @csrf

                <div class="mb-2">
                    <label class="block text-sm font-medium">Titre</label>
                    <input name="title" required class="w-full border rounded px-2 py-1 text-sm">
                </div>

                <div class="mb-2">
                    <label class="block text-sm font-medium">Description</label>
                    <textarea name="description" class="w-full border rounded px-2 py-1 text-sm"></textarea>
                </div>

                <div class="mb-2">
                    <label class="block text-sm font-medium">Priorité</label>
                    <select name="priority" class="w-full border rounded px-2 py-1 text-sm">
                        <option value="">--</option>
                        <option value="low">Basse</option>
                        <option value="medium">Moyenne</option>
                        <option value="high">Haute</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Date limite</label>
                    <input type="date" name="due_date" class="w-full border rounded px-2 py-1 text-sm">
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="open = false"
                            class="text-sm px-4 py-1 border rounded">Annuler</button>
                    <button type="submit"
                            class="bg-blue-600 text-white text-sm px-4 py-1 rounded hover:bg-blue-700">Créer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Calendrier -->
    <div id="calendar"></div>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            editable: true,
            eventDrop: function (info) {
                fetch('{{ route('tasks.updateDate') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: info.event.id,
                        due_date: info.event.startStr
                    })
                }).then(response => {
                    if (!response.ok) {
                        alert("Erreur lors de la mise à jour.");
                        info.revert();
                    }
                });
            },
            events: [
                @foreach ($project->columns as $column)
                    @foreach ($column->tasks as $task)
                        @if ($task->due_date)
                        {
                            id: '{{ $task->id }}',
                            title: '[{{ $column->name }}] {{ $task->title }}',
                            start: '{{ $task->due_date->toDateString() }}',
                            color: '{{ $task->priority === 'high' ? '#dc2626' : ($task->priority === 'medium' ? '#f59e0b' : '#10b981') }}'
                        },
                        @endif
                    @endforeach
                @endforeach
            ]
        });

        calendar.render();
    });
</script>
@endpush