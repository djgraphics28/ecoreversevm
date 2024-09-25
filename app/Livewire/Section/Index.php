<?php

namespace App\Livewire\Section;

use Livewire\Component;
use App\Models\Section;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination, LivewireAlert;

    public $searchTerm = '';  // Search term for section search
    protected $paginationTheme = 'bootstrap';  // Using Bootstrap for pagination

    protected $listeners = ['delete'];
    public $approveConfirmed;

    // Reset pagination when search term is updated
    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Filter sections by search term and paginate
        $sections = Section::where('name', 'like', '%' . $this->searchTerm . '%')
            ->paginate(10);  // Paginate with 10 per page

        return view('livewire.section.index', compact('sections'));
    }

    public function alertConfirm($id)
    {
        $this->approveConfirmed = $id;

        $this->confirm('Are you sure you want to delete this section?', [
            'confirmButtonText' => 'Yes, Delete it!',
            'onConfirmed' => 'delete',
        ]);
    }

    public function delete()
    {
        $section = Section::findOrFail($this->approveConfirmed);
        $section->delete();

        // Add a success message (using LivewireAlert or session flash)
        $this->alert('success', 'Section has been deleted successfully.');
    }
}
