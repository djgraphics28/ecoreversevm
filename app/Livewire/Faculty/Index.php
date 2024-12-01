<?php

namespace App\Livewire\Faculty;

use App\Models\User;
use App\Models\Faculty;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Index extends Component
{
    use WithPagination, LivewireAlert, WithFileUploads;

    public $facultyId, $title, $first_name, $middle_name, $last_name, $gender, $email, $phone, $birth_date;

    public $image;
    public $faculty;
    public $searchTerm = '';
    public $modalOpen = false; // Modal control

    public function render()
    {

        return view('livewire.faculty.index',  [
            'faculties' => $this->records
        ]);
    }

    public function getRecordsProperty()
    {
        $query = Faculty::query();

        if ($this->searchTerm) {
            $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
        }

        return $query->paginate(10);
    }


    public function openModal($id = null)
    {
        $this->resetFields();

        if ($id) {
            $faculty = Faculty::findOrFail($id);
            $this->facultyId = $faculty->id;
            $this->title = $faculty->title;
            $this->first_name = $faculty->first_name;
            $this->middle_name = $faculty->middle_name;
            $this->last_name = $faculty->last_name;
            $this->gender = $faculty->gender;
            $this->email = $faculty->email;
            $this->phone = $faculty->phone;
            $this->birth_date = $faculty->birth_date;
        }

        $this->modalOpen = true;
    }

    public function deleteFaculty($id)
    {
        Faculty::findOrFail($id)->delete();
        $this->alert('success', 'Faculty deleted successfully.');
    }

    private function resetFields()
    {
        $this->facultyId = null;
        $this->image = null;
        $this->title = '';
        $this->first_name = '';
        $this->middle_name = '';
        $this->last_name = '';
        $this->gender = '';
        $this->email = '';
        $this->phone = '';
        $this->birth_date = '';
    }

    public function saveFaculty()
    {
        try {
            $validationRules = [
                'title' => 'required|string|max:255',
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string|max:255',
                'gender' => 'required|in:male,female',
                'birth_date' => 'required|date',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image upload
            ];

            // Only require email validation for new records
            if (!$this->facultyId) {
                $validationRules['email'] = 'required|email|unique:faculties,email';
                $validationRules['phone'] = 'required|string|unique:faculties,phone';
            }

            $this->validate($validationRules);

            $faculty = Faculty::updateOrCreate(
                ['id' => $this->facultyId],
                [
                    'title' => $this->title,
                    'first_name' => $this->first_name,
                    'middle_name' => $this->middle_name,
                    'last_name' => $this->last_name,
                    'gender' => $this->gender,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'birth_date' => $this->birth_date,
                ]
            );

            // Handle Image Upload
            if ($this->image) {
                $faculty->clearMediaCollection('profile'); // Clear existing media
                $faculty->addMedia($this->image->getRealPath())
                    ->toMediaCollection('profile'); // Upload new image
            }

            $this->alert('success', $this->facultyId ? 'Faculty updated successfully.' : 'Faculty created successfully.');

            $this->resetFields();
            $this->modalOpen = false;
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function createUserAccount($id)
    {
        $faculty = Faculty::findOrFail($id);

        //check if the email is already registered in users table
        $user = User::where('email', $faculty->email)->first();

        if($user) {
            $this->alert('error', 'Email already existing');
            return;
        }

        $createUser = User::create([
            'name' => $faculty->first_name . ' ' . $faculty->last_name,
            'email' => $faculty->email,
            'password' => Hash::make($faculty->last_name),
        ]);

        if($createUser) {
            $createUser->assignRole('faculty');
            $faculty->user_id = $createUser->id;
            $faculty->save();
        }

        $this->alert('success', 'User account created successfully.');
    }

    public function resetAccount($id)
    {
        $faculty = Faculty::findOrFail($id);
        $user = User::find($faculty->user_id);
        if($user) {
            $user->update([
                'password' => Hash::make($faculty->last_name),
            ]);
        }
        $this->alert('success', 'User account reset successfully.');
    }
}
