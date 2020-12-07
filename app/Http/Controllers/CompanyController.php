<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;

use App\Models\Address;
use App\Models\Company;
use App\Models\Country;

class CompanyController extends Controller
{
    public function show(Company $company, Request $request) {
        $company = $request->user()->company;
        $company->load(['headquarters_address', 'headquarters_address.country', 'addresses', 'addresses.country'])->loadCount(['invoices', 'pending_invoices']);
        $countries = Country::get();

        return view('company.show', [
            'company' => $company,
            'countries' => $countries,
        ]);
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

        return redirect()->route('company.show');
    }

    public function update(CompanyUpdateRequest $request) {
        $company = $request->user()->company;

        $company->update([
            'name' => $request->name,
        ]);

        $company->headquarters_address->update([
            'company_id' => $company->id,
            'label' => $request->name,
            'street_address' => $request->street_address,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'country_code' => $request->country_code,
        ]);

        return redirect()->route('company.show');
    }
}
