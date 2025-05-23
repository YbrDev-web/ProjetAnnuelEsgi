<x-app-layout>
    <x-slot name="header">
        
    </x-slot>

    <!-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <strong>{{ __("S'inscrire pour voir votre board") }}</strong>
                    <h3>{{ __("Le board") }}</h3>
                </div>
            </div>
        </div>
    </div> -->
    
    <div class="flex-1 flex flex-col justify-center items-center text-center px-4">
        <h1 class="text-2xl sm:text-3xl font-semibold text-gray-800 mb-3">
            S’inscrire pour voir votre board
        </h1>
        <p class="text-gray-500 mb-6 text-sm">
            Le board sur lequel vous voulez avoir accès nécessite une connexion
        </p>
        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
            S’inscrire
        </a>
        <p class="text-xs text-gray-500 mt-4">
            Déjà un compte ? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Connectez ici</a>
        </p>
    </div>
</x-app-layout>
