<?php

namespace App\Livewire\Section;

use Livewire\Component;
use App\Models\Section;
use Illuminate\Database\Eloquent\Model;

class Create extends Component
{
    public $name;
    public $faculty;
    public $faculties;

    public function mount()
    {
        $this->faculties = \App\Models\Faculty::all();
    }

    // Method to create a new section
    public function createSection()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Please type the section name because it\'s required.',
        ]);

        // Create the section
        $section = Section::create([
            'name' => $this->name,
            'faculty_id' => $this->faculty,
        ]);

        // Flash message for success
        if ($section instanceof Model) {
            toastr()->success('New Section has been saved successfully!');

            return redirect()->route('sections.index');
        }

        toastr()->error('An error has occurred, please try again later.');

        return back();
    }

    public function render()
    {
        return view('livewire.section.create');
    }
}
