<?php

namespace App\Http\Livewire;

use App\Models\PelangganProfile;
use Livewire\Component;
use Livewire\WithPagination;

class PelangganTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'users.name';
    public $sortDirection = 'asc';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $pelanggans = PelangganProfile::with('user')
            ->join('users', 'pelanggan_profiles.user_id', '=', 'users.id')
            ->where(function ($query) {
                $query->where('users.name', 'like', '%' . $this->search . '%')
                    ->orWhere('users.email', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->select('pelanggan_profiles.*')
            ->paginate(10);

        return view('livewire.pelanggan-table', compact('pelanggans'));
    }
}
