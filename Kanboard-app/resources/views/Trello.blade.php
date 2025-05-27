<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Trello
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="flex justify-center gap-6 flex-wrap">

            <!-- Colonne 1 : To-do -->
            <div class="w-[300px] bg-white dark:bg-gray-800 rounded-lg shadow-md flex flex-col">
                <div class="p-4 text-gray-900 dark:text-white font-bold border-b border-gray-300 dark:border-gray-700">
                    To-do
                </div>
                <div class="p-4 space-y-2 max-h-[400px] overflow-y-auto">
                    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Affiche promotionnelle</div>
                    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Publicité sur les chaînes TV</div>
                    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche C</div>
                    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche D</div>
                </div>
                <button class="p-3 text-sm text-blue-600 hover:underline text-left">
                    + Ajouter une carte
                </button>
            </div>

            <!-- Colonne 2 : In Progress -->
            <div class="w-[300px] bg-white dark:bg-gray-800 rounded-lg shadow-md flex flex-col">
                <div class="p-4 text-gray-900 dark:text-white font-bold border-b border-gray-300 dark:border-gray-700">
                    In Progress
                </div>
                <div class="p-4 space-y-2 max-h-[400px] overflow-y-auto">
                    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche E</div>
                    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche F</div>
                </div>
                <button class="p-3 text-sm text-blue-600 hover:underline text-left">
                    + Ajouter une carte
                </button>
            </div>

            <!-- Colonne 3 : Done -->
            <div class="w-[300px] bg-white dark:bg-gray-800 rounded-lg shadow-md flex flex-col">
                <div class="p-4 text-gray-900 dark:text-white font-bold border-b border-gray-300 dark:border-gray-700">
                    Done
                </div>
                <div class="p-4 space-y-2 max-h-[400px] overflow-y-auto">
                    <div class="bg-blue-100 dark:bg-blue-700 p-3 rounded">Tâche G</div>
                    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">Tâche H</div>
                </div>
                <button class="p-3 text-sm text-blue-600 hover:underline text-left">
                    + Ajouter une carte
                </button>
            </div>
        </div>

        <!-- Bouton : Ajouter une autre liste -->
        <div class="flex justify-center mt-6">
            <button class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-full shadow-sm transition duration-200">
                <span class="text-xl">+</span>
                <span>Ajouter une autre liste</span>
            </button>
        </div>
    </div>

    <div class="w-64 bg-blue-100 p-4 rounded-r-lg text-sm">
  <div class="mb-4">
    <h2 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">
      📥 Inbox
    </h2>
    <div class="bg-white p-3 rounded shadow-sm">
      <p class="text-gray-700 mb-1">Téléchargez l'application mobile Trello et capturez où que vous soyez.</p>
      <a href="#" class="text-blue-600 underline text-sm">Téléchargez l'application Trello</a>
    </div>
  </div>
  
  <div class="mt-10 flex items-center gap-2 text-gray-700">
    🔒 <span>Une boîte de réception 100 % privée</span>
  </div>
</div>

</x-app-layout>





