<?php

// app/Http/Controllers/Superadmin/EmployeeController.php
namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\Mitra;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['user', 'mitra'])->get();
        return view('superadmin.employees.index', compact('employees'));
    }

    public function create()
    {
        $users = User::where('role', 'employee')->doesntHave('employee')->get();
        $mitras = Mitra::where('status_approve', 'disetujui')->get();
        return view('superadmin.employees.create', compact('users', 'mitras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'mitra_id' => 'required|exists:mitras,id',
            'no_telepon' => 'required|string|max:255',
        ]);

        Employee::create($request->all());

        return redirect()->route('superadmin.employees.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit(Employee $employee)
    {
        $users = User::where('role', 'employee')->get();
        $mitras = Mitra::where('status_approve', 'disetujui')->get();
        return view('superadmin.employees.edit', compact('employee', 'users', 'mitras'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'mitra_id' => 'required|exists:mitras,id',
            'no_telepon' => 'required|string|max:255',
        ]);

        $employee->update($request->all());

        return redirect()->route('superadmin.employees.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('superadmin.employees.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}