<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Trello
        </h2>
    </x-slot>

    <div class="flex">
        <!-- Sidebar : Inbox -->
        <aside class="w-64 bg-blue-100 p-6 rounded-r-lg text-sm h-full sticky top-0">
            <div class="mb-6">
                <h2 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">
                    📥 Inbox
                </h2>
                <div class="bg-white p-3 rounded shadow-sm">
                    <p class="text-gray-700 mb-1">
                        Téléchargez l'application mobile Trello et capturez où que vous soyez.
                    </p>
                    <a href="#" class="text-blue-600 underline text-sm">
                        Télécharger l'application Trello
                    </a>
                </div>
            </div>

            <div class="mt-10 flex items-center gap-2 text-gray-700">
                🔒 <span>Une boîte de réception 100 % privée</span>
            </div>
        </aside>

        <!-- Contenu principal -->
        <main class="flex-1 p-6 overflow-auto">
            <div class="flex justify-center gap-6 flex-wrap">

                @php
                    $columns = [
                        'To-do' => ['Affiche promotionnelle', 'Publicité sur les chaînes TV', 'Tâche C', 'Tâche D'],
                        'In Progress' => ['Tâche E', 'Tâche F'],
                        'Done' => ['Tâche G', 'Tâche H'],
                    ];
                @endphp

                @foreach ($columns as $title => $tasks)
                    <div class="w-[300px] bg-white dark:bg-gray-800 rounded-lg shadow-md flex flex-col">
                        <div class="p-4 text-gray-900 dark:text-white font-bold border-b border-gray-300 dark:border-gray-700">
                            {{ $title }}
                        </div>
                        <div class="p-4 space-y-2 max-h-[400px] overflow-y-auto">
                            @foreach ($tasks as $task)
                                <div class="@if($task === 'Tâche G') bg-blue-100 dark:bg-blue-700 @else bg-gray-100 dark:bg-gray-700 @endif p-3 rounded">
                                    {{ $task }}
                                </div>
                            @endforeach
                        </div>
                        <button class="p-3 text-sm text-blue-600 hover:underline text-left">
                            + Ajouter une carte
                        </button>
                    </div>
                @endforeach

            </div>

            <!-- Ajouter une autre liste -->
            <div class="flex justify-center mt-6">
                <button class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-full shadow-sm transition duration-200">
                    <span class="text-xl">+</span>
                    <span>Ajouter une autre liste</span>
                </button>
            </div>
        </main>
    </div>
</x-app-layout>






