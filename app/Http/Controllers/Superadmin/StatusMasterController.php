<?php
namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatusMaster;

class StatusMasterController extends Controller
{
    public function index()
    {
        $statuses = StatusMaster::all();
        return view('superadmin.status_master.index', compact('statuses'));
    }

    public function create()
    {
        return view('superadmin.status_master.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama_status' => 'required|string|max:255']);
        StatusMaster::create($request->only('nama_status'));
        return redirect()->route('superadmin.status-master.index')->with('success', 'Status berhasil ditambahkan.');
    }

    public function edit(StatusMaster $statusMaster)
    {
        return view('superadmin.status_master.edit', compact('statusMaster'));
    }

    public function update(Request $request, StatusMaster $statusMaster)
    {
        $request->validate(['nama_status' => 'required|string|max:255']);
        $statusMaster->update($request->only('nama_status'));
        return redirect()->route('superadmin.status-master.index')->with('success', 'Status berhasil diperbarui.');
    }

    public function destroy(StatusMaster $statusMaster)
    {
        $statusMaster->delete();
        return redirect()->route('superadmin.status-master.index')->with('success', 'Status berhasil dihapus.');
    }
}
