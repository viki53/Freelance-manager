<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($customers as $i => $customer)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <a href="{{ route('customers.show', ['customer' => $customer]) }}" class="block p-6">
                    <div class="flex items-center">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><strong>{{ $customer->name }}</strong></div>
                    </div>

                    <div class="ml-12">
                        <div class="mt-2 text-sm text-gray-500">
                            {{ nl2br($customer->headquarters_address->street_address) }}<br>
                            {{ $customer->headquarters_address->postal_code }}
                            {{ $customer->headquarters_address->city }}<br>
                            {{ $customer->headquarters_address->country->name }}
                        </div>
                    </div>
                </a>
                @if(!empty($customer->invoices_count))
                <a href="{{ route('invoices.list') }}" class="block p-6 border-t border-gray-200 bg-orange-100">
                    Voir @choice(':count facture|:count factures', $customer->invoices_count) en attente
                </a>
                @endif
            </div>
            @endforeach

            <form method="POST" id="customer-create-form" action="{{ route('customers.create') }}" class="mt-8 p-4 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @csrf

                <x-jet-validation-errors class="mb-4" />

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
                        {{ __('Ajouter un client') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
