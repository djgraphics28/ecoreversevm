<?php

namespace App\Livewire\Students;

use Livewire\Component;
use App\Models\Student;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, LivewireAlert;

    public $searchTerm = '';
    public $approveConfirmed;

    protected $listeners = ['deleteStudent'];

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

    // Method to delete the student
    // public function deleteStudent($studentId)
    // {
    //     $student = Student::find($studentId);

    //     if ($student) {
    //         $student->delete();
    //         toastr()->success('Student has been deleted successfully!');
    //     } else {
    //         toastr()->error('An error occurred. Please try again.');
    //     }
    // }

    public function alertConfirm($studentId)
    {
        $this->approveConfirmed = $studentId;

        $this->alert('warning', 'Are you sure you want to delete this student?', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'deleteStudent',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, Delete it!',
            'cancelButtonText' => 'Cancel',
        ]);
    }

    public function increment($studentId)
    {
        $student = Student::find($studentId);
        $student->increment('points'); // Increment points by 1
    }

    public function decrement($studentId)
    {
        $student = Student::find($studentId);
        $student->decrement('points'); // Decrement points by 1
    }

    public function deleteStudent()
    {
        $student = Student::findOrFail($this->approveConfirmed);
        $student->delete();

        // Add a success message (using LivewireAlert or session flash)
        $this->alert('success', 'Student has been deleted successfully.');
    }
}
