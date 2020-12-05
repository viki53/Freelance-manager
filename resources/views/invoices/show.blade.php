<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Factures') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(empty($invoice->items))
            <div class="bg-orange-200 overflow-hidden shadow-xl sm:rounded-lg p-8">
                <p>Facture vierge</p>
            </div>
            @else
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @foreach($invoice->items as $i => $item)
                <div class="{{ $i % 2 == 1 ? 'bg-gray-200' : 'bg-white' }} bg-opacity-25 grid grid-cols-1 md:grid-cols-5">
                    <div>
                        <p class="p-2"><strong>{{ $item->label }}</strong></p>
                        <p class="p-2">{{ $item->description }}</p>
                    </div>
                    <div>
                        <p class="p-2">
                            {{ $item->quantity }}
                            @choice($item->item_type->label_singular.'|'.$item->item_type->label_plural, $item->quantity)
                            à
                            {{ $item->unit_price }} €
                        </p>
                    </div>
                    <div>
                        <p class="p-2">
                            {{ $item->untaxed_price }} €<br>
                            <acronym title="Hors taxes">HT</acronym>
                        </p>
                    </div>
                    <div>
                        <p class="p-2">
                            {{ $item->taxes_price }} €<br>
                            <acronym title="Taxe sur la Valeur Ajoutée">TVA</acronym>
                            ({{ $item->tax_rate->percentage }}%)
                        </p>
                    </div>
                    <div>
                        <p class="p-2">
                            {{ $item->taxed_price }} €<br>
                            <acronym title="Toutes Taxes Comprises">TTC</acronym>
                        </p>
                    </div>
                </div>
                @endforeach
                <div class="bg-white border-t border-gray-200 dark:border-gray-700 grid grid-cols-1 md:grid-cols-5">
                    <p class="p-3">
                        <strong>Total</strong>
                    </p>
                    <p class="p-3">
                        {{ $invoice->items_count }} @choice('élément|éléments', $invoice->items_count)
                    </p>
                    <p class="p-3">
                        {{ $invoice->untaxed_total }} €
                        <acronym title="Hors taxes">HT</acronym>
                    </p>
                    <p class="p-3">
                        {{ $invoice->taxes_total }} €
                        <acronym title="Taxe sur la Valeur Ajoutée">TVA</acronym>
                    </p>
                    <p class="p-3">
                        {{ $invoice->taxed_total }} €
                        <acronym title="Toutes Taxes Comprises">TTC</acronym>
                    </p>
                </div>
            </div>
            @endif

            <x-jet-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('invoices.items.add', ['invoice' => $invoice]) }}" class="mt-8 p-3 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="md:pr-1">
                        <div>
                            <x-jet-label for="label" value="{{ __('Libellé') }}" />
                            <x-jet-input id="label" class="block mt-1 w-full" type="text" name="label" :value="old('label')" required autofocus autocomplete="on" />
                        </div>

                        <div>
                            <x-jet-label for="description" value="{{ __('Description') }}" />
                            <x-textarea id="description" class="block mt-1 w-full" name="description" rows="6" autocomplete="on">{{ old('description') }}</x-textarea>
                        </div>
                    </div>

                    <div class="md:pl-1">
                        <div>
                            <x-jet-label for="quantity" value="{{ __('Quantité') }}" />
                            <x-jet-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" :value="old('quantity')" required autocomplete="on" />
                        </div>

                        <div>
                            <x-jet-label for="item_type_id" value="{{ __('Unité') }}" />
                            <x-select id="item_type_id" class="block mt-1 w-full" type="text" name="item_type_id" :value="old('item_type_id')" required autocomplete="off">
                                @foreach($itemTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->label_singular }} / {{ $type->label_plural }}</option>
                                @endforeach
                            </x-select>
                        </div>

                        <div>
                            <x-jet-label for="unit_price" value="{{ __('Prix unitaire') }}" />
                            <x-jet-input id="unit_price" class="block mt-1 w-full" type="number" name="unit_price" :value="old('unit_price')" required autocomplete="on" />
                        </div>

                        <div>
                            <x-jet-label for="tax_rate_id" value="{{ __('Taxe') }}" />
                            <x-select id="tax_rate_id" class="block mt-1 w-full" type="text" name="tax_rate_id" :value="old('tax_rate_id')" required autocomplete="off">
                                @foreach($taxRates as $rate)
                                <option value="{{ $rate->id }}">{{ $rate->label }} ({{ $rate->percentage }})</option>
                                @endforeach
                            </x-select>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-jet-button class="ml-4">
                        {{ __('Nouvelle ligne') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
