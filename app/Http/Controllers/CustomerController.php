<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerCreateRequest;

use App\Models\Address;
use App\Models\Company;
use App\Models\Country;

class CustomerController extends Controller
{
    public function list(Request $request) {
        $customers = $request->user()->company->customers()->with(['headquarters_address', 'headquarters_address.country'])->withCount(['received_invoices'])->get();
        $countries = Country::get();

        return view('customers.list', [
            'customers' => $customers,
            'countries' => $countries
        ]);
    }

    public function show(Company $customer, Request $request) {
        $customer->load(['addresses'])->loadCount(['received_invoices']);

        return view('customers.show', ['customer' => $customer]);
    }

    public function create(CustomerCreateRequest $request) {
        $customer = Company::create([
            'name' => $request->name,
            'customer_of' => $request->user()->company->id,
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

        $customer->headquarters_address_id = $address->id;
        $customer->save();

        return redirect()->route('customers.show', ['customer' => $customer]);
    }
}
