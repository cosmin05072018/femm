<style>
    .logo-img {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
<?php

// dd(Hash::make('Cosmin1!')); $2y$12$SUGqnA4YaEQowHb2JoJpV.RdNRX92/GVgqmwLYmkF1GJlV6hmZ81W cosmin1@fe.ro
// dd(Hash::make('Cosmin2!')); $2y$12$YGvJAyImp5dh2/dbpvHgU.I18iKUljSXMQ7GBOYYYvggb7arsp0ly cosmin2@fe.ro
// dd(Hash::make('Cosmin3!')); $2y$12$WG7YMPEZ9IglGFlc.OPKO.QJAqVu4m.r05UYZWe3o6M33xwekbI1. cosmin3@fe.ro

?>
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Parolă')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Ține-mă minte') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between my-4">
            <x-primary-button class="ms-3">
                {{ __('Conecteză-te') }}
            </x-primary-button>
            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Nu ai cont? Crează unul</a>
            @endif
        </div>
        @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('password.request') }}">
                {{ __('Ți-ai uitat parola?') }}
            </a>
        @endif
    </form>
</x-guest-layout>
