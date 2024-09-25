<?php

namespace App\Livewire\GradeLevel;

use Livewire\Component;
use App\Models\GradeLevel;
use Illuminate\Database\Eloquent\Model;

class Create extends Component
{
    public $name;

    // Method to create a new grade level
    public function createGradeLevel()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Please type the grade level name because it\'s required.',
        ]);

        // Create the grade level
        $gradeLevel = GradeLevel::create([
            'name' => $this->name,
        ]);

        // Flash message for success
        if ($gradeLevel instanceof Model) {
            toastr()->success('New Grade Level has been saved successfully!');

            return redirect()->route('grade-levels.index');
        }

        toastr()->error('An error has occurred, please try again later.');

        return back();
    }

    public function render()
    {
        return view('livewire.grade-level.create');
    }
}
