<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CompanyCreateRequest;

use App\Models\Address;
use App\Models\Company;
use App\Models\Country;

class CompanyController extends Controller
{
    public function list(Request $request) {
        $companies = $request->user()->companies()->with(['headquarters_address', 'headquarters_address.country'])->withCount(['invoices'])->get();
        $countries = Country::get();

        return view('companies.list', [
            'companies' => $companies,
            'countries' => $countries
        ]);
    }

    public function show(Company $company, Request $request) {
        $company->load(['addresses'])->loadCount(['invoices']);

        return view('companies.show', ['company' => $company]);
    }

    public function create(CompanyCreateRequest $request) {
        $company = Company::create([
            'name' => $request->name,
            'owner_id' => $request->user()->id,
            'headquarters_adress_id' => null,
        ]);

        $address = Address::create([
            'company_id' => $company->id,
            'label' => $request->name,
            'street_address' => $request->street_address,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'country_code' => $request->country_code,
        ]);

        $company->headquarters_address_id = $address->id;
        $company->save();

        return redirect()->route('companies.list');
    }

    public function invoices(Company $company, Request $request) {
        $invoices = $company->invoices()->with('items')->withCount('items')->get();

        return view('invoices.list', [
            'company' => $company,
            'invoices' => $invoices
        ]);
    }
    public function createInvoice(Company $company, InvoiceCreateRequest $request) {
        $invoice = Invoice::create([
            'company_id' => $company->id,
        ]);

        return redirect()->route('invoices.show', ['invoice' => $invoice]);
    }
}
