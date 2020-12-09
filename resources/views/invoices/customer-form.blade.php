@if(!count($company->customers))
<p class="mb-6 font-semibold text-xl">Pensez à ajouter un client pour pouvoir envoyer la facture</p>
@else
<form method="POST" action="{{ route('invoices.update', ['invoice' => $invoice]) }}" wire:submit.prevent="update">
    @csrf
    <p class="mb-6 font-semibold text-xl">
        <label for="customer_id">Facture destinée à</label>
        <x-select id="customer_id" name="invoice.customer_id" class="text-xs ml-2" wire:model="invoice.customer_id">
            <option value="">— Choisir un client —</option>
            @foreach($company->customers as $customer)
            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
            @endforeach
        </x-select>
        <noscript><x-jet-button type="submit">Valider</x-jet-button></noscript>

        <a href="{{ route('customers.list', ['invoice_id' => $invoice->id]) }}#customer-create-form" class="ml-4 inline-flex items-center text-sm font-semibold text-indigo-700">
            Nouveau client

            <span class="ml-1 text-indigo-500">
                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </span>
        </a>
    </p>
    @error('invoice.customer_id')
    <p class="error">{{ $message }}</p>
    @enderror

    @if (session()->has('invoice_customer_update'))
        <div class="my-3 bg-green-300 p-2 rounded">
            {{ session('invoice_customer_update') }}
        </div>
    @endif
</form>
@endif
