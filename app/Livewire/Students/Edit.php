<?php

namespace App\Livewire\Students;

use Livewire\Component;
use App\Models\Student;
use App\Models\GradeLevel;
use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $studentId;
    public $student_number;
    public $rfid_code;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $birth_date;
    public $gender;
    public $grade_level_id;
    public $section_id;
    public $points = 0;
    public $student_picture;
    public $student; // To hold the student instance

    public $gradeLevels; // To hold the grade levels
    public $sections; // To hold the sections

    // Lifecycle method to initialize the component
    public function mount($studentId)
    {
        $student = Student::find($studentId);
        $this->student = $student;

        $this->student_number = $student->student_number;
        $this->rfid_code = $student->rfid_code;
        $this->first_name = $student->first_name;
        $this->middle_name = $student->middle_name;
        $this->last_name = $student->last_name;
        $this->birth_date = $student->birth_date;
        $this->gender = $student->gender;
        $this->grade_level_id = $student->grade_level_id;
        $this->section_id = $student->section_id;
        $this->points = $student->points;

        $this->gradeLevels = GradeLevel::all(); // Fetch all grade levels
        $this->sections = Section::all(); // Fetch all sections
    }

    // Method to update the student
    public function updateStudent()
    {
        $this->validate([
            'student_number' => 'required|string|max:255',
            'rfid_code' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'grade_level_id' => 'required|exists:grade_levels,id',
            'section_id' => 'required|exists:sections,id',
            'student_picture' => 'nullable|image|max:2048', // 2MB Max
        ], [
            'student_number.required' => 'Please enter the student number.',
            'rfid_code.required' => 'Please enter the RFID code.',
            'first_name.required' => 'Please enter the first name.',
            'last_name.required' => 'Please enter the last name.',
            'birth_date.required' => 'Please enter the birth date.',
            'gender.required' => 'Please select the gender.',
            'grade_level_id.required' => 'Please select a grade level.',
            'section_id.required' => 'Please select a section.',
            'student_picture.image' => 'The student picture must be an image.',
            'student_picture.max' => 'The student picture must not be greater than 2MB.',
        ]);

        // Update the student
        $this->student->update([
            'student_number' => $this->student_number,
            'rfid_code' => $this->rfid_code,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'grade_level_id' => $this->grade_level_id,
            'section_id' => $this->section_id,
            'points' => $this->points,
        ]);

        // If there's a picture, update it using Media Library
        if ($this->student_picture) {
            // Clear the old media
            $this->student->clearMediaCollection('student_pictures');

            $this->student->addMedia($this->student_picture->getRealPath())
                ->usingName($this->student_picture->getClientOriginalName())
                ->toMediaCollection('student_pictures');
        }

        // Flash message for success
        toastr()->success('Student details have been updated successfully!');

        return redirect()->route('students.index');
    }

    public function render()
    {
        return view('livewire.students.edit');
    }
}
