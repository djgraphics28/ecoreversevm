<?php

namespace App\Livewire\MissionVision;

use App\Models\MissionVision;
use App\Models\VissionMission;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Index extends Component
{
    use LivewireAlert;
    public $vision;
    public $mission;

    // Load existing data (if any) when the component mounts
    public function mount()
    {
        $missionVision = MissionVision::first();
        $this->vision = $missionVision ? $missionVision->vision_text : '';
        $this->mission = $missionVision ? $missionVision->mission_text : '';
    }

    // Save the Vision and Mission
    public function save()
    {
        MissionVision::updateOrCreate(
            ['id' => 1],
            [
                'vision_text' => $this->vision,
                'mission_text' => $this->mission,
            ]
        );

        $this->alert('success', 'Vision and Mission saved successfully!');
    }
    public function render()
    {
        return view('livewire.mission-vision.index');
    }
}
