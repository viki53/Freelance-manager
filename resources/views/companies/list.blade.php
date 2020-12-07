<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Entreprises') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @foreach($companies as $i => $company)
                <div class="{{ $i % 2 == 1 ? 'bg-gray-200' : 'bg-white' }} bg-opacity-25">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="{{ route('companies.show', ['company' => $company]) }}">{{ $company->name }}</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                                {{ nl2br($company->headquarters_address->street_address) }}<br>
                                {{ $company->headquarters_address->postal_code }}
                                {{ $company->headquarters_address->city }}<br>
                                {{ $company->headquarters_address->country->name }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <x-jet-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('companies.create') }}" class="mt-8 p-4 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @csrf

                <div>
                    <x-jet-label for="name" value="{{ __('Nom') }}" />
                    <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="organization" />
                </div>

                <div>
                    <x-jet-label for="street_address" value="{{ __('Adresse') }}" />
                    <x-textarea id="street_address" class="block mt-1 w-full" name="street_address" required autocomplete="street-address">{{ old('street_address') }}</x-textarea>
                </div>

                <div>
                    <x-jet-label for="postal_code" value="{{ __('Code postal') }}" />
                    <x-jet-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code" maxlength="5" :value="old('postal_code')" required autocomplete="postal-code" />
                </div>

                <div>
                    <x-jet-label for="city" value="{{ __('Ville') }}" />
                    <x-jet-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required autocomplete="city" />
                </div>

                <div>
                    <x-jet-label for="country_code" value="{{ __('Pays') }}" />
                    <x-select id="country_code" class="block mt-1 w-full" type="text" name="country_code" :value="old('country_code')" required autocomplete="country">
                        @foreach($countries as $country)
                        <option value="{{ $country->code }}">{{ $country->name }}</option>
                        @endforeach
                    </x-select>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-jet-button class="ml-4">
                        {{ __('Créer une entreprise') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
