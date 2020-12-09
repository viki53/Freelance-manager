<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Http\Requests\InvoiceCreateRequest;
use App\Http\Requests\InvoiceUpdateRequest;
use App\Http\Requests\InvoiceItemCreateRequest;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\ItemType;
use App\Models\TaxRate;

class InvoiceController extends Controller
{
    public function list(Request $request) {
        $invoices = $request->user()->invoices()->orderBy('created_at', 'desc')->with('items')->withCount('items')->get();
        $archived_invoices = $request->user()->invoices()->onlyTrashed()->orderBy('deleted_at', 'desc')->with('items')->withCount('items')->get();

        return view('invoices.list', [
            'user' => $request->user(),
            'invoices' => $invoices,
            'archived_invoices' => $archived_invoices,
        ]);
    }

    public function create(InvoiceCreateRequest $request) {
        $invoice = Invoice::create([
            'company_id' => $request->user()->company->id,
            'customer_id' => $request->customer_id,
        ]);

        return redirect()->route('invoices.show', ['invoice' => $invoice]);
    }

    public function show(Invoice $invoice, Request $request) {
        $invoice->load(['company', 'customer', 'items']);

        $itemTypes = ItemType::get();
        $taxRates = TaxRate::get();

        return view('invoices.show', [
            'user' => $request->user(),
            'invoice' => $invoice,
            'itemTypes' => $itemTypes,
            'taxRates' => $taxRates,
        ]);
    }

    public function update(Invoice $invoice, InvoiceUpdateRequest $request) {
        $invoice->customer_id = $request->customer_id;
        $invoice->save();

        return redirect()->route('invoices.show', ['invoice' => $invoice]);
    }

    public function send(Invoice $invoice, InvoiceSendRequest $request) {
        $invoice->sent_at = $request->date ? $request->date : Carbon::now();
        $invoice->save();

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
        $invoice->save();

        return redirect()->route('invoices.show', ['invoice' => $invoice]);
    }

    public function delete(Invoice $invoice) {
        $invoice->delete();
        return redirect()->route('invoices.list');
    }

    public function restore($invoiceId) {
        Invoice::onlyTrashed()->findOrFail($invoiceId)->restore();
        return redirect()->route('invoices.list');
    }
}
