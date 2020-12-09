<?php

namespace App\Http\Livewire\Invoice;

use Livewire\Component;

use App\Models\Company;
use App\Models\Invoice;

class CustomerForm extends Component
{
    public Company $company;
    public Invoice $invoice;

    protected $rules = [
        'invoice.customer_id' => 'nullable|exists:App\Models\Company,id'
    ];

    public function updated()
    {
        $this->validate();

        if (empty($this->invoice->customer_id)) {
            $this->invoice->customer_id = null;
            $this->invoice->sent_at = null;
        }
        $this->invoice->save();

        session()->flash('invoice_customer_update', 'Client mis à jour.');
    }

    public function render()
    {
        return view('invoices.customer-form');
    }
}
