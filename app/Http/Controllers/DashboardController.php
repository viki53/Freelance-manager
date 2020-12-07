<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $user = $request->user();
        $user->load(['company']);
        $user->company->loadCount(['customers', 'invoices', 'pending_invoices']);

        return view('dashboard', [
            'user' => $user,
        ]);
    }
}
