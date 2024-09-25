<?php

namespace App\Livewire\GradeLevel;

use App\Models\GradeLevel;
use Livewire\Component;

class Edit extends Component
{
    public $gradeLevel;
    public $gradeLevelId;
    public $name;

    // Mount method to populate the form with existing grade level data
    public function mount($gradeLevelId)
    {
        $gradeLevel = GradeLevel::find($gradeLevelId);
        $this->gradeLevel = $gradeLevel;
        $this->name = $gradeLevel->name;
    }

    // Method to update an existing workflow
    public function updateGradeLevel()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Please type the grade level name because it\'s required.',
        ]);

        // Update the grade level
        $this->gradeLevel->update([
            'name' => $this->name,
        ]);

        // Flash message for success
        toastr()->success('Grade Level has been updated successfully!');

        return redirect()->route('grade-levels.index');
    }

    public function render()
    {
        return view('livewire.grade-level.edit', [
            'gradeLevel' => $this->gradeLevel,
        ]);
    }
}
