<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

class SuperAdminController extends Controller
{
    public function index()
    {
        return view('superadmin.dashboard');
    }
}
