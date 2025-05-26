<x-app-layout>
    <x-slot name="header">
        
    </x-slot>


    <div class="flex justify-center gap-6 flex-wrap p-6">
    <!-- Colonne 1 avec scroll -->
    <div class="w-[300px] bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-4 text-gray-900 dark:text-gray-100 font-bold border-b border-gray-300 dark:border-gray-700">
            To-do
        </div>
        <div class="p-4 space-y-2 max-h-[400px] overflow-y-scroll">
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Affiche promotionnelle</div>
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Publicité sur les chaines tv</div>
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche C</div>
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche D</div>
        </div>
        <button class="p-3 text-sm text-blue-600 hover:underline text-left">
                + Ajouter une carte
        </button>
    </div>
    <div class="w-[300px] bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-4 text-gray-900 dark:text-gray-100 font-bold border-b border-gray-300 dark:border-gray-700">
            In-progress 
        </div>
        <div class="p-4 space-y-2 max-h-[400px] overflow-y-auto">
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche E</div>
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche F</div>
        </div>
        <button class="p-3 text-sm text-blue-600 hover:underline text-left">
                + Ajouter une carte
        </button>
    </div>
    <div class="w-[300px] bg-white dark:bg-gray-600 rounded-lg shadow-md">
    <div class="p-4 text-gray-900 dark:text-gray-100 font-bold border-b border-gray-300 dark:border-gray-700">
        Finish
    </div>
    <button class="p-3 text-sm text-blue-600 hover:underline text-left">
        + Ajouter une carte
    </button>
</div>
</x-app-layout>
<button class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-full shadow-sm transition duration-200">
    <span class="text-xl">+</span>
    <span>Ajoutez une autre liste</span>
</button>

