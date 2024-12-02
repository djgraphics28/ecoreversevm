<?php

namespace App\Livewire\Faculty\Student;

use App\Models\Faculty;
use App\Models\Section;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $searchTerm = '';

    // Method to render the student index view
    public function render()
    {
        $facultyId = Faculty::where('user_id',Auth::user()->id)->first()->id;

        $sectionId = Section::where('faculty_id', $facultyId)->first()->id;
        // dd($sectionId);

        $students = Student::where('section_id', $sectionId)
            ->paginate(10); // Adjust pagination as needed

        return view('livewire.faculty.student.index', [
            'students' => $students,
        ]);
    }

    // Method to confirm deletion
    public function alertConfirm($studentId)
    {
        // Logic to handle confirmation and deletion
        $this->dispatchBrowserEvent('swal:confirm', [
            'id' => $studentId,
            'message' => 'Are you sure you want to delete this student?',
        ]);
    }

    // Method to delete the student
    public function deleteStudent($studentId)
    {
        $student = Student::find($studentId);

        if ($student) {
            $student->delete();
            toastr()->success('Student has been deleted successfully!');
        } else {
            toastr()->error('An error occurred. Please try again.');
        }
    }
}
