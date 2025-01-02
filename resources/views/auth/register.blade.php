<style>
    .logo-img {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    select {
        background-color: #111827 !important;
        /* Fundal întunecat */
        color: #cbd5e0 !important;
        /* Text deschis la culoare */
        border: 1px solid #4a5568 !important;
        /* Bordură similară cu celelalte câmpuri */
        padding: 0.5rem !important;
        border-radius: 0.375rem !important;
        /* Rotunjirea colțurilor */
        height: 40px !important;
        /* Înălțime similară */
        width: 100% !important;
        /* Se extinde pe toată lățimea */
        appearance: none !important;
        /* Îndepărtează stilul implicit pentru browsere */
    }

    /* Săgeata din dreapta pentru select */
    select::-ms-expand {
        display: none !important;
        /* Ascunde săgeata în Internet Explorer */
    }

    /* Stil pentru placeholder */
    select option[value=""][disabled] {
        color: #a0aec0 !important;
        /* Culoare mai pală pentru placeholder */
    }

    /* Hover și focus pentru select */
    select:hover,
    select:focus {
        border-color: #718096 !important;
        /* Culoare pentru border la hover și focus */
        outline: none !important;
    }
</style>

<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Județ -->
        <div>
            <x-input-label for="county" :value="__('Selectează Județul')" />
            <select id="county" name="county" class="block mt-1 w-full select2" required>
                <option value=""></option>
                @foreach(['Alba', 'Arad', 'Argeș', 'Bacău', 'Bihor', 'Bistrița-Năsăud', 'Botoșani', 'Brașov', 'Brăila', 'București', 'Buzău', 'Caraș-Severin', 'Călărași', 'Cluj', 'Constanța', 'Covasna', 'Dâmbovița', 'Dolj', 'Galați', 'Giurgiu', 'Gorj', 'Harghita', 'Hunedoara', 'Ialomița', 'Iași', 'Ilfov', 'Maramureș', 'Mehedinți', 'Mureș', 'Neamț', 'Olt', 'Prahova', 'Satu Mare', 'Sălaj', 'Sibiu', 'Suceava', 'Teleorman', 'Timiș', 'Tulcea', 'Vaslui', 'Vâlcea', 'Vrancea'] as $county)
                    <option value="{{ $county }}" {{ old('county') === $county ? 'selected' : '' }}>{{ $county }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('county')" class="mt-2" />
        </div>

        <!-- Nume Firmă -->
        <div>
            <x-input-label for="company_name" class="mt-3" :value="__('Nume Firmă')" />
            <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')"
                required autocomplete="name" />
            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
        </div>

        <!-- Nume Hotel -->
        <div>
            <x-input-label for="hotel_name" class="mt-3" :value="__('Nume Hotel')" />
            <x-text-input id="hotel_name" class="block mt-1 w-full" type="text" name="hotel_name" :value="old('hotel_name')"
                required autocomplete="name" />
            <x-input-error :messages="$errors->get('hotel_name')" class="mt-2" />
        </div>

        <!-- CUI Firmă -->
        <div>
            <x-input-label class="mt-3" for="company_cui" :value="__('CUI Firmă')" />
            <x-text-input id="company_cui" class="block mt-1 w-full" type="number" name="company_cui" :value="old('company_cui')"
                required autocomplete="company_cui" />
            <x-input-error :messages="$errors->get('company_cui')" class="mt-2" />
        </div>

        <!-- Nume Admin Firmă -->
        <div>
            <x-input-label class="mt-3" for="manager_name" :value="__('Nume Manager')" />
            <x-text-input id="manager_name" class="block mt-1 w-full" type="text" name="manager_name" :value="old('manager_name')"
                required autocomplete="manager_name" />
            <x-input-error :messages="$errors->get('manager_name')" class="mt-2" />
        </div>

        <!-- Sediu Firmă -->
        <div>
            <x-input-label class="mt-3" for="company_address" :value="__('Sediu Firmă')" />
            <x-text-input id="company_address" class="block mt-1 w-full" type="text" name="company_address" :value="old('company_address')"
                required autocomplete="company_address" />
            <x-input-error :messages="$errors->get('company_address')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Ai deja un cont? Conectează-te') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Solicită Înregistrarea') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
