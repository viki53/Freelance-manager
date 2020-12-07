<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $user = $request->user();
        $user->loadCount(['companies', 'invoices']);

        return view('dashboard', [
            'user' => $user,
            'invoices_count' => $user->invoices_count,
            'pending_invoices_count' => $user->invoices_count,
            'companies_count' => $user->companies_count,
        ]);
    }
}
