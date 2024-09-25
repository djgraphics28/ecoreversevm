<?php

namespace App\Livewire\Students;

use Livewire\Component;
use App\Models\Student;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $searchTerm = '';

    // Method to render the student index view
    public function render()
    {
        $students = Student::query()
            ->where('first_name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('student_number', 'like', '%' . $this->searchTerm . '%')
            ->orderBy('id', 'desc')
            ->paginate(10); // Adjust pagination as needed

        return view('livewire.students.index', [
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
