<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $mitra = auth()->user()->mitra;

        if (!$mitra) {
            abort(403, 'Mitra tidak ditemukan.');
        }

        $employees = Employee::where('mitra_id', $mitra->id)
            ->with('user')
            ->get();

        return view('mitra.employee.index', compact('employees'));
    }

    public function create()
    {
        return view('mitra.employee.create');
    }

    public function store(Request $request)
    {
        $mitra = auth()->user()->mitra;

        if (!$mitra) {
            abort(403, 'Mitra tidak ditemukan.');
        }

        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:8|confirmed',
            'no_telepon'   => 'required|string|regex:/^([0-9]{10,15})$/|unique:employees,no_telepon',
        ], [
            'no_telepon.regex'  => 'Nomor telepon harus berupa angka dan memiliki panjang 10-15 digit.',
            'no_telepon.unique' => 'Nomor telepon sudah digunakan.',
            'email.unique'      => 'Email sudah terdaftar.',
        ]);

        DB::beginTransaction();

        try {
            // Buat user baru untuk pegawai
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'employee',
            ]);

            // Buat entry employee yang terhubung ke mitra dan user
            Employee::create([
                'mitra_id'    => $mitra->id,
                'user_id'     => $user->id,
                'no_telepon'  => $request->no_telepon,
            ]);

            DB::commit();

            return redirect()
                ->route('mitra.employee.index')
                ->with('success', 'Karyawan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menambahkan karyawan: ' . $e->getMessage()]);
        }
    }

    public function edit(Employee $employee)
    {
        $mitra = auth()->user()->mitra;

        if (!$mitra || $employee->mitra_id !== $mitra->id) {
            abort(403, 'Akses ditolak.');
        }

        return view('mitra.employee.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $mitra = auth()->user()->mitra;

        if (!$mitra || $employee->mitra_id !== $mitra->id) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'no_telepon' => 'required|string|regex:/^([0-9]{10,15})$/|unique:employees,no_telepon,' . $employee->id,
        ], [
            'no_telepon.regex'  => 'Nomor telepon harus berupa angka dan memiliki panjang 10-15 digit.',
            'no_telepon.unique' => 'Nomor telepon sudah digunakan.',
        ]);

        $employee->update([
            'no_telepon' => $request->no_telepon,
        ]);

        return redirect()
            ->route('mitra.employee.index')
            ->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        $mitra = auth()->user()->mitra;

        if (!$mitra || $employee->mitra_id !== $mitra->id) {
            abort(403, 'Akses ditolak.');
        }

        $employee->delete();

        return redirect()
            ->route('mitra.employee.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }
}
