<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Pricing
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-10">
        <!-- Fonctionnalités -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <!-- ... [tes cartes de fonctionnalités] ... -->
        </div>

        <!-- Formulaire d'abonnement -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md max-w-2xl mx-auto">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Choisissez votre abonnement</h3>

            <form method="POST" action="#">
                @csrf

                <!-- Type d’abonnement -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Type d’abonnement</label>
                    <select name="plan" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        <option value="free">Gratuit</option>
                        <option value="pro">Prenium – 19,99€/mois</option>
                        <option value="enterprise">Entreprise – 35€/mois</option>
                    </select>
                </div>

                <!-- Moyen de paiement -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Moyen de paiement</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="payment" value="card" class="text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Carte bancaire</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="payment" value="paypal" class="text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">PayPal</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="payment" value="crypto" class="text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Crypto-monnaie</span>
                        </label>
                    </div>
                </div>

                <!-- Bouton -->
                <div class="mt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow-sm">
                        Valider mon abonnement
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
