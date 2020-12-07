<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Factures') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($invoices as $invoice)
            <a href="{{ route('invoices.show', ['invoice' => $invoice]) }}" class="block mb-3 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><strong>{{ $invoice->created_at->isoFormat('D MMMM YYYY, HH\hmm') }}</strong></div>
                    </div>

                    <div class="ml-12 mt-2 grid grid-cols-2">
                        <div class="text-sm text-gray-500">
                            {{ $invoice->quantity_total }} @choice('élément|éléments', $invoice->quantity_total)
                        </div>
                        <div class="flex justify-end text-sm text-gray-500">
                            @money_format($invoice->taxed_total, 'EUR')&nbsp;<acronym title="Toutes Taxes Comprises">TTC</acronym>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach

            <x-jet-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('invoices.create') }}" class="mt-8">
                @csrf

                <div class="flex items-center justify-end mt-4">
                    <x-jet-button class="ml-4">
                        {{ __('Nouvelle facture') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>