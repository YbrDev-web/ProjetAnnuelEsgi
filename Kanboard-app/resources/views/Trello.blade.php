<div class="w-[280px] bg-white dark:bg-gray-800 rounded-xl shadow-md flex flex-col p-3 space-y-3">
    <!-- Titre de la colonne -->
    <div class="flex justify-between items-center">
        <h3 class="text-sm font-semibold text-gray-800 dark:text-white">To do</h3>
        <button class="text-gray-400 hover:text-gray-600 text-lg">⋯</button>
    </div>

    <!-- Cartes de tâches -->
    @foreach ($Tasks as $Task)
        <div class="bg-white border border-gray-200 dark:bg-gray-700 dark:border-gray-600 rounded-lg p-3 shadow-sm space-y-2">
            <h4 class="text-sm font-medium text-gray-800 dark:text-white">{{ $task->title }}</h4>
            <div class="flex items-center text-xs text-gray-500 dark:text-gray-300">
                <svg class="w-4 h-4 mr-1 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
            </div>
        </div>
    @endforeach

    <!-- Ajouter une carte -->
    <button class="text-sm text-gray-600 dark:text-gray-300 hover:underline flex items-center gap-1 mt-auto">
        <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        Ajouter une carte
    </button>
</div>


