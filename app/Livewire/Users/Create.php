<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use App\Models\Building;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class Create extends Component
{
    public $name;
    public $email;
    public $password;
    public $roles;

    // Method to create a new user
    public function createUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'roles' => 'required|max:1',
        ], [
            'roles.required' => 'Please choose at least one role.',
        ]);

        // Create the user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),  // Hashing the password
        ]);

        // Assign selected roles to the user
        $user->roles()->attach($this->roles);

        // Assign selected buildings to user
        $user->buildings()->sync($this->buildings);

        // Flash message for success
        if ($user instanceof Model) {

            toastr()->success('New User has been saved successfully!');

            // Send email verification
            $user->sendEmailVerificationNotification();

            toastr()->success('Email Verification has been sent to '. $this->email);

            return redirect()->route('users.index');
        }

        toastr()->error('An error has occurred please try again later.');

        return back();
    }

    public function render()
    {
        // Fetch available roles from the database
        $availableRoles = Role::all();

        return view('livewire.users.create', compact('availableRoles'));
    }
}
