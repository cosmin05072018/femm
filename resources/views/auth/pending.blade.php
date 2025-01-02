<!-- resources/views/registration/pending.blade.php -->
<style>
    .logo-img {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<x-guest-layout>
    <div class="max-w-md mx-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mt-8">
        <div class="text-center">
            <!-- Icon sau imagine pentru o mai bună reprezentare -->
            <svg class="mx-auto h-16 w-16 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>

            <h1 class="mt-4 text-2xl font-semibold text-gray-900 dark:text-gray-100">Înregistrare în Așteptare</h1>
        </div>

        @if (session('status'))
            <div class="mt-4 text-green-600 dark:text-green-400 text-center">
                {{ session('status') }}
            </div>
        @endif

        <div class="mt-6 text-center">
            <a href="{{ route('StartApp') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                &larr; Înapoi la pagina principală
            </a>
        </div>
    </div>
</x-guest-layout>
