<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Menampilkan daftar employee dengan search dan pagination
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $employees = Employee::with(['user', 'mitra'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('mitra', function ($q) use ($search) {
                    $q->where('nama_toko', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('superadmin.employees.index', compact('employees', 'search'));
    }

    /**
     * Menghapus employee beserta user-nya
     */
    public function destroy(Employee $employee)
    {
        if ($employee->user) {
            $employee->user->delete();
        }

        $employee->delete();

        return redirect()->route('superadmin.employees.index')
            ->with('success', 'Employee berhasil dihapus.');
    }
}
