<?php

namespace App\Livewire\Students;

use App\Models\Student;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section; // Ensure to import the Section model
use App\Models\GradeLevel; // Ensure to import the GradeLevel model

class Create extends Component
{
    use WithFileUploads;

    // public $email;
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

    public $gradeLevels; // To hold the grade levels
    public $sections; // To hold the sections

    // Lifecycle method to initialize the component
    public function mount()
    {
        $this->gradeLevels = GradeLevel::all(); // Fetch all grade levels
        $this->sections = Section::all(); // Fetch all sections
    }

    // Method to create a new student
    public function createStudent()
    {
        $this->validate([
            // 'email' => 'required|email',
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

        // Create the student
        $student = Student::create([
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
            // 'email' => $this->email,
            'password' => strtolower($this->last_name),
            // 'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // If there's a picture, store it using Media Library
        if ($this->student_picture) {
            $student->addMedia($this->student_picture->getRealPath())
                ->usingName($this->student_picture->getClientOriginalName())
                ->toMediaCollection('student_pictures');
        }

        // Flash message for success
        if ($student instanceof Model) {
            toastr()->success('New Student has been saved successfully!');

            return redirect()->route('students.index');
        }

        toastr()->error('An error has occurred, please try again later.');

        return back();
    }

    public function render()
    {
        return view('livewire.students.create');
    }
}
