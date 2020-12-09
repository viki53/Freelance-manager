@if($invoice->is_ready_to_send)
<form method="POST" action="{{ route('invoices.send', ['invoice' => $invoice]) }}" wire:submit.prevent="send" id="invoice-send-form" class="mt-8 mb-6 flex items-right justify-end">
    @csrf
    <div class="font-semibold">
        <p>
            <label for="send_later">Envoyer plus tard</label>

            <input type="checkbox" id="send_later" class="text-xs ml-1" name="send_later" value="true" wire:model="send_later" {{ old('send_later', !empty($invoice->sent_at)) ? 'checked' : '' }} />

            <label for="sent_at" class="ml-1">le</label>
            <x-jet-input type="date" id="sent_at" class="text-xs ml-1 {{ !$send_later ? 'bg-gray-100' : '' }}" name="date" wire:model="date" min="{{ $today->isoFormat('YYYY-MM-DD') }}" disabled="{{ !$send_later }}" value="{{ old('date', (($send_later && $invoice->sent_at) ? $invoice->sent_at->format('YYYY-MM-DD') : null)) }}" />
        </p>
        @error('date')
        <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <x-jet-button class="ml-4">
            {{ __('Envoyer la facture') }}
        </x-jet-button>
    </div>
</form>
@elseif($invoice->is_sent && $invoice->sent_at >= $today)
<p class="mt-8 bg-blue-500 text-white p-2 rounded">Cette facture sera envoyée le {{ $invoice->sent_at->isoFormat('D MMMM YYYY \à HH\hmm') }}</p>
@elseif($invoice->is_sent && $invoice->sent_at > $today)
<p class="mt-8 bg-blue-500 text-white p-2 rounded">Cette facture a déjà été envoyée le {{ $invoice->sent_at->isoFormat('D MMMM YYYY \à HH\hmm') }}</p>
@endif
