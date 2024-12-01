<?php

namespace App\Livewire;

use App\Models\Faculty;
use App\Models\Section;
use App\Models\Student;
use Livewire\Component;
use App\Models\MissionVision;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $totalStudents = 0;
    public $totalFaculties = 0;
    public $mission = '';
    public $vision = '';

    public function mount()
    {
        if(Auth::user()->is_admin) {
            $this->totalStudents = Student::count();
        } else {
            $facultyId = Faculty::where('user_id', Auth::user()->id)->first()->id;
            $sectionIds = Section::where('faculty_id', $facultyId)->pluck('id');
            $this->totalStudents = Student::whereIn('section_id', $sectionIds)->count();
        }

        // $this->totalFaculties = \App\Models\Faculty::count();
        $missionVision = MissionVision::find(1);
        $this->mission = $missionVision->mission_text ?? null;
        $this->vision = $missionVision->vision_text ?? null;
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
