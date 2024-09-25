<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use App\Models\Building;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class Edit extends Component
{
    public $user;           // This will hold the user being edited
    public $name;           // For binding the 'name' field
    public $email;          // For binding the 'email' field
    public $password;       // For binding the 'password' field (optional)
    public $roles = [];     // For binding the 'roles' dropdown
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'password' => 'nullable|min:6',
        'roles' => 'required',
    ];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;

        // Ensure pluck always returns an array
        $this->roles = $user->roles->pluck('id')->toArray();   // Convert to array
    }

    public function updateUser()
    {
        $this->validate();

        // Update the user
        $this->user->name = $this->name;
        $this->user->email = $this->email;

        // Only update the password if it's provided
        if ($this->password) {
            $this->user->password = Hash::make($this->password);
        }

        $this->user->save();

        // Sync roles and buildings (if many-to-many relation)
        $this->user->roles()->sync($this->roles);

        // Redirect or send a success message
        session()->flash('success', 'User updated successfully!');
        return redirect()->route('users.index');
    }

    public function render()
    {
        // Fetch available roles from the database
        $availableRoles = Role::all();

        return view('livewire.users.edit', compact('availableRoles'));
    }
}
