<?php

namespace App\Livewire\Section;

use App\Models\Section;
use Livewire\Component;

class Edit extends Component
{
    public $section;
    public $sectionId;
    public $name;
    public $faculty;
    public $faculties;

    // Mount method to populate the form with existing section data
    public function mount($sectionId)
    {
        $section = Section::find($sectionId);
        $this->section = $section;
        $this->name = $section->name;
        $this->faculty = $section->faculty_id;
        $this->faculties = \App\Models\Faculty::all();
    }

    // Method to update an existing section
    public function updateSection()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Please type the section name because it\'s required.',
        ]);

        // Update the section
        $this->section->update([
            'name' => $this->name,
            'faculty_id' => $this->faculty,
        ]);

        // Flash message for success
        toastr()->success('Section has been updated successfully!');

        return redirect()->route('sections.index');
    }

    public function render()
    {
        return view('livewire.section.edit', [
            'section' => $this->section,
        ]);
    }
}
