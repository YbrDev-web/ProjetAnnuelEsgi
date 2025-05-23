<x-app-layout>
    <x-slot name="header">
        
    </x-slot>


    <div class="flex justify-center gap-6 flex-wrap p-6">
    <!-- Colonne 1 avec scroll -->
    <div class="w-[300px] bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-4 text-gray-900 dark:text-gray-100 font-bold border-b border-gray-300 dark:border-gray-700">
            To-do
        </div>
        <div class="p-4 space-y-2 max-h-[400px] overflow-y-auto">
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Affiche promotionnelle</div>
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Publicité sur les chaines tv</div>
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche C</div>
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche D</div>
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche E</div>
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche F</div>
        </div>
        <button class="p-3 text-sm text-blue-600 hover:underline text-left">
                + Ajouter une carte
        </button>
    </div>

    <div class="w-[300px] bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-4 text-gray-900 dark:text-gray-100 font-bold border-b border-gray-300 dark:border-gray-700">
            in course
        </div>
        <div class="p-4 space-y-2 max-h-[400px] overflow-y-auto">
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche C</div>
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche D</div>
        </div>
        <button class="p-3 text-sm text-blue-600 hover:underline text-left">
                + Ajouter une carte
        </button>
    </div>

    <div class="w-[300px] bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-4 text-gray-900 dark:text-gray-100 font-bold border-b border-gray-300 dark:border-gray-700">
            Finish
        </div>
        <div class="p-4 space-y-2">
            <div class="bg-blue-100 dark:bg-blue-700 p-3 rounded">Tâche E</div>
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche F</div>
        </div>
        <button class="p-3 text-sm text-blue-600 hover:underline text-left">
                + Ajouter une carte
        </button>
    </div>
</div>
</x-app-layout>

