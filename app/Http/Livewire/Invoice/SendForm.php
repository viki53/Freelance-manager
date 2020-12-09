<?php

namespace App\Http\Livewire\Invoice;

use Livewire\Component;
use Illuminate\Support\Carbon;

use App\Models\Invoice;

class SendForm extends Component
{
    public $send_later = false;
    public $date = null;
    public Invoice $invoice;
    public Carbon $today;

    protected $rules = [
        'date' => 'nullable|date|after:today'
    ];

    public function __construct() {
        parent::__construct();
        $this->today = Carbon::now();
    }

    public function updated()
    {
        $this->validate();
    }

    public function send() {
        $this->invoice->sent_at = $this->date ? new Carbon($this->date) : Carbon::now();
        $this->invoice->save();

        return redirect()->route('invoices.show', ['invoice' => $this->invoice]);
    }

    public function render() {
        return view('invoices.send-form');
    }
}
