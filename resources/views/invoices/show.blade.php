<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('invoices.list') }}">{{ __('Factures') }}</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('invoice.customer-form', ['invoice' => $invoice, 'company' => $user->company])

            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                @if(empty($invoice->items))
                <div class="bg-orange-200 p-8">
                    <p>Facture vierge</p>
                </div>
                @else
                <div class="bg-white">
                    @foreach($invoice->items as $i => $item)
                    <div class="{{ $i % 2 == 1 ? 'bg-gray-200' : 'bg-white' }} bg-opacity-25 flex">
                        <div class="w-full md:w-4/6">
                            <div class="p-2">
                                <p><strong>{{ $item->label }}</strong></p>
                                @if(!empty($item->description))
                                <p class="mt-2">{!! nl2br(e($item->description)) !!}</p>
                                @endif
                            </div>
                        </div>
                        <div class="w-full md:w-2/6 grid grid-cols-1 md:grid-cols-2">
                            <div class="p-2 text-right">
                                <p>
                                    @number_format($item->quantity)
                                    @choice($item->item_type->label_singular.'|'.$item->item_type->label_plural, $item->quantity)
                                    à
                                    @money_format($item->unit_price, 'EUR')
                                </p>
                                <p>
                                    <acronym title="Taxe sur la Valeur Ajoutée">TVA</acronym>&nbsp;@number_format($item->tax_rate->percentage) %
                                </p>
                            </div>
                            <p class="p-2 text-right">
                                @money_format($item->taxed_price, 'EUR')&nbsp;<acronym title="Toutes Taxes Comprises">TTC</acronym>
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif


                @if(!$invoice->is_sent)
                <x-jet-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('invoices.items.add', ['invoice' => $invoice]) }}" class="p-3 border-t border-gray-200">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="md:pr-1">
                            <div class="p-1 ph-2">
                                <x-jet-label for="label" value="{{ __('Libellé') }}" />
                                <x-jet-input id="label" class="block mt-1 w-full" type="text" name="label" :value="old('label')" required autocomplete="on" />
                            </div>

                            <div class="p-1 ph-2">
                                <x-jet-label for="description" value="{{ __('Description') }}" />
                                <x-textarea id="description" class="block mt-1 w-full" name="description" rows="6" autocomplete="on">{{ old('description') }}</x-textarea>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:pl-1">
                            <div class="p-1 ph-2">
                                <x-jet-label for="quantity" value="{{ __('Quantité') }}" />
                                <x-jet-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" :value="old('quantity')" required autocomplete="on" />
                            </div>

                            <div class="p-1 ph-2">
                                <x-jet-label for="item_type_id" value="{{ __('Unité') }}" />
                                <x-select id="item_type_id" class="block mt-1 w-full" type="text" name="item_type_id" :value="old('item_type_id')" required autocomplete="off">
                                    @foreach($itemTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->label_singular }} / {{ $type->label_plural }}</option>
                                    @endforeach
                                </x-select>
                            </div>

                            <div class="p-1 ph-2">
                                <x-jet-label for="unit_price" value="{{ __('Prix unitaire') }}" />
                                <x-jet-input id="unit_price" class="block mt-1 w-full" type="number" name="unit_price" :value="old('unit_price')" required autocomplete="on" />
                            </div>

                            <div class="p-1 ph-2">
                                <x-jet-label for="tax_rate_id" value="{{ __('Taxe') }}" />
                                <x-select id="tax_rate_id" class="block mt-1 w-full" type="text" name="tax_rate_id" :value="old('tax_rate_id')" required autocomplete="off">
                                    @foreach($taxRates as $rate)
                                    <option value="{{ $rate->id }}">{{ $rate->label }} (@number_format($rate->percentage) %)</option>
                                    @endforeach
                                </x-select>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-jet-button class="ml-4">
                            {{ __('Ajouter') }}
                        </x-jet-button>
                    </div>
                </form>
                @endif
            </div>

            @if(!empty($invoice->items))
            <div class="mt-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex">
                    <p class="p-3 ph-2 text-right w-1/2 md:w-5/6">
                        <strong>Total <acronym title="Hors taxes">HT</acronym></strong>
                    </p>
                    <p class="p-3 ph-2 text-right w-1/2 md:w-1/6">
                        @money_format($invoice->untaxed_total, 'EUR')
                    </p>
                </div>
                <div class="flex">
                    <p class="p-3 ph-2 text-right w-1/2 md:w-5/6">
                        <strong><acronym title="Taxe sur la Valeur Ajoutée">TVA</acronym></strong>
                    </p>
                    <p class="p-3 ph-2 text-right w-1/2 md:w-1/6">
                        @money_format($invoice->taxes_total, 'EUR')
                    </p>
                </div>
                <div class="flex">
                    <p class="p-3 ph-2 text-right w-1/2 md:w-5/6">
                        <strong>Total <acronym title="Toutes Taxes Comprises">TTC</acronym></strong>
                    </p>
                    <p class="p-3 ph-2 text-right w-1/2 md:w-1/6">
                        @money_format($invoice->taxed_total, 'EUR')
                    </p>
                </div>
            </div>
            @endif

            @livewire('invoice.send-form', ['invoice' => $invoice])
        </div>
    </div>
</x-app-layout>
