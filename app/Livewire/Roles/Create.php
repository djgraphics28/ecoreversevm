<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;
    public $role_name;
    public $selectedPermissions = [];

    // Fetch all permissions grouped by their category (e.g., 'users', 'roles', etc.)
    public function getGroupedPermissionsProperty()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode(' ', $permission->name)[1] ?? 'general';
        });

        return $permissions;
    }

    public function toggleSelectAll($group)
    {
        $permissions = $this->groupedPermissions[$group]->pluck('name')->toArray();

        if (array_intersect($permissions, $this->selectedPermissions) === $permissions) {
            // If all permissions in the group are selected, uncheck them all
            $this->selectedPermissions = array_diff($this->selectedPermissions, $permissions);
        } else {
            // Otherwise, check all permissions in the group
            $this->selectedPermissions = array_unique(array_merge($this->selectedPermissions, $permissions));
        }
    }

    // Store the new role with its selected permissions
    public function createRole()
    {
        $this->validate([
            'role_name' => 'required|string|max:255',
            'selectedPermissions' => 'required|array',
        ]);

        $role = Role::create(['name' => $this->role_name]);
        $role->syncPermissions($this->selectedPermissions);

        if ($role instanceof Model) {
            toastr()->success('New Role has been saved successfully!');

            return redirect()->route('roles.permissions');
        }

        toastr()->error('An error has occurred please try again later.');

        return back();
    }
    public function render()
    {
        return view('livewire.roles.create');
    }
}
