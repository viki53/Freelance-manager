<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\InvoiceCreateRequest;
use App\Http\Requests\InvoiceItemCreateRequest;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\ItemType;
use App\Models\TaxRate;

class InvoiceController extends Controller
{
    public function list(Request $request) {
        $company = $request->user()->default_company;
        $invoices = $company->invoices()->with('items')->withCount('items')->get();

        return view('invoices.list', [
            'company' => $company,
            'invoices' => $invoices
        ]);
    }

    public function show(Invoice $invoice, Request $request) {
        $invoice->load(['company', 'items'])->loadCount('items');

        $itemTypes = ItemType::get();
        $taxRates = TaxRate::get();

        return view('invoices.show', [
            'invoice' => $invoice,
            'itemTypes' => $itemTypes,
            'taxRates' => $taxRates,
        ]);
    }

    public function create(InvoiceCreateRequest $request) {
        $invoice = Invoice::create([
            'company_id' => $request->company_id ?: $request->user()->default_company->id,
        ]);

        return redirect()->route('invoices.show', ['invoice' => $invoice]);
    }

    public function addItem(Invoice $invoice, InvoiceItemCreateRequest $request) {
        $item = InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'label' => $request->label,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'item_type_id' => $request->item_type_id,
            'tax_rate_id' => $request->tax_rate_id,
        ]);

        return redirect()->route('invoices.show', ['invoice' => $invoice]);
    }
}
