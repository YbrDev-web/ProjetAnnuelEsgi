<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <strong>{{ __("S'inscrire pour voir votre board") }}</strong>
                    <h3>{{ __("Le board") }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center gap-6 flex-wrap p-6">
    <!-- Colonne 1 -->
    <div class="w-[300px] bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-4 text-gray-900 dark:text-gray-100 font-bold border-b border-gray-300 dark:border-gray-700">
            Kanboard - Projet 1
        </div>
        <div class="p-4 space-y-2">
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche A</div>
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche B</div>
        </div>
    </div>

    <!-- Colonne 2 -->
    <div class="w-[300px] bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-4 text-gray-900 dark:text-gray-100 font-bold border-b border-gray-300 dark:border-gray-700">
            Kanboard - Projet 2
        </div>
        <div class="p-4 space-y-2">
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche C</div>
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche D</div>
        </div>
    </div>

    <!-- Colonne 3 -->
    <div class="w-[300px] bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-4 text-gray-900 dark:text-gray-100 font-bold border-b border-gray-300 dark:border-gray-700">
            Kanboard - Projet 3
        </div>
        <div class="p-4 space-y-2">
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche E</div>
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche F</div>
        </div>
    </div>
</div>
</x-app-layout>
