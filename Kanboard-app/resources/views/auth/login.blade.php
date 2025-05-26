<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 px-4">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 space-y-6">
            
            <!-- Titre -->
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Connexion à votre compte</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Entrez vos identifiants pour continuer</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                    <x-text-input id="email" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Mot de passe')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                    <x-text-input id="password" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:focus:ring-indigo-600" name="remember">
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Se souvenir de moi') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 hover:underline dark:text-indigo-400" href="{{ route('password.request') }}">
                            {{ __('Mot de passe oublié ?') }}
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <div>
                    <x-primary-button class="w-full justify-center bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white py-2 rounded-md">
                        {{ __('Se connecter') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

