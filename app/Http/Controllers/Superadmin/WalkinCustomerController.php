<?php

// app/Http/Controllers/Superadmin/WalkinCustomerController.php
namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\WalkinCustomer;
use Illuminate\Http\Request;

class WalkinCustomerController extends Controller
{
    public function index()
    {
        $walkinCustomers = WalkinCustomer::with('mitra')->get();
        return view('superadmin.walkin_customer.index', compact('walkinCustomers'));
    }

    public function show(WalkinCustomer $walkinCustomer)
    {
        $walkinCustomer->load('mitra', 'pesanans');
        return view('superadmin.walkin_customer.show', compact('walkinCustomer'));
    }
}