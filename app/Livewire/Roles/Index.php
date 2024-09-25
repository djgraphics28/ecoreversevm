<?php

namespace App\Livewire\Roles;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    use WithPagination, LivewireAlert;

    public $searchTerm = '';  // Search term

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['delete'];
    public $approveConfirmed;

    // Resetting pagination when searching
    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Filter roles by search term and paginate
        $roles = Role::with('permissions')
            ->where('name', 'like', '%' . $this->searchTerm . '%')
            ->paginate(10); // Paginate with 10 per page

        return view('livewire.roles.index', compact('roles'));
    }

    public function alertConfirm($id)
    {
        $this->approveConfirmed = $id;

        $this->confirm('Are you sure you want to delete this?', [
            'confirmButtonText' => 'Yes Delete it!',
            'onConfirmed' => 'delete',
        ]);
    }

    public function delete()
    {
        $role = Role::findOrFail($this->approveConfirmed);
        $role->delete();

        toastr()->success('Role has been deleted successfully.');
    }
}
