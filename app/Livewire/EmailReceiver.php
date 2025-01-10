<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EmailReceiver as ER;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EmailReceiver extends Component
{
    use WithPagination, LivewireAlert;

    public $receiverId, $email;

    public $receiver;
    public $searchTerm = '';
    public $modalOpen = false; // Modal control

    public function render()
    {

        return view('livewire.email-receiver',  [
            'receivers' => $this->records
        ]);
    }

    public function getRecordsProperty()
    {
        $query = ER::query();

        if ($this->searchTerm) {
            $query->where('email', 'like', '%' . $this->searchTerm . '%');
        }

        return $query->paginate(10);
    }


    public function openModal($id = null)
    {
        $this->resetFields();

        if ($id) {
            $receiver = ER::findOrFail($id);
            $this->receiverId = $receiver->id;
            $this->email = $receiver->email;
        }

        $this->modalOpen = true;
    }

    public function delete($id)
    {
        ER::findOrFail($id)->delete();
        $this->alert('success', 'Receiver deleted successfully.');
    }

    private function resetFields()
    {
        $this->email = '';
    }

    public function saveReceiver()
    {
        try {
            // Only require email validation for new records
            $validationRules['email'] = 'required|email';

            $this->validate($validationRules);

            $receiver = ER::updateOrCreate(
                ['id' => $this->receiverId],
                [
                    'email' => $this->email
                ]
            );

            $this->alert('success', $this->receiverId ? 'Receiver updated successfully.' : 'Receiver created successfully.');

            $this->resetFields();
            $this->modalOpen = false;
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }
}
