<?php

namespace App\Livewire\GradeLevel;

use Livewire\Component;
use App\Models\GradeLevel;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination, LivewireAlert;

    public $searchTerm = '';  // Search term for workflow search
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
        // Filter grade level by search term and paginate
        $gradeLevels = GradeLevel::where('name', 'like', '%' . $this->searchTerm . '%')
            ->paginate(10);  // Paginate with 10 per page

        return view('livewire.grade-level.index', compact('gradeLevels'));
    }

    public function alertConfirm($id)
    {
        $this->approveConfirmed = $id;

        $this->confirm('Are you sure you want to delete this grade level?', [
            'confirmButtonText' => 'Yes, Delete it!',
            'onConfirmed' => 'delete',
        ]);
    }

    public function delete()
    {
        $gradeLevel = GradeLevel::findOrFail($this->approveConfirmed);
        $gradeLevel->delete();

        // Add a success message (using LivewireAlert or session flash)
        $this->alert('success', 'Grade Level has been deleted successfully.');
    }
}
