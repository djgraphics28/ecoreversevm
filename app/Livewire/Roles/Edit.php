<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;

    public $roleId;
    public $role_name;
    public $selectedPermissions = [];

    public function mount($roleId)
    {
        $this->roleId = $roleId;

        // Fetch the role details based on the roleId
        $role = Role::findOrFail($roleId);
        $this->role_name = $role->name;

        // Load the role's permissions
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
    }

    // Group permissions by category (similar to create)
    public function getGroupedPermissionsProperty()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode(' ', $permission->name)[1] ?? 'general';
        });

        return $permissions;
    }

    // Update role details
    public function updateRole()
    {
        $this->validate([
            'role_name' => 'required|string|max:255',
            'selectedPermissions' => 'required|array',
        ]);

        // Update role
        $role = Role::findOrFail($this->roleId);
        $role->update(['name' => $this->role_name]);

        // Sync permissions
        $role->syncPermissions($this->selectedPermissions);

        toastr()->success('Role updated successfully!');
        return redirect()->route('roles.permissions');
    }

    public function toggleSelectAll($group)
    {
        $permissions = $this->groupedPermissions[$group]->pluck('name')->toArray();

        if (array_intersect($permissions, $this->selectedPermissions) === $permissions) {
            $this->selectedPermissions = array_diff($this->selectedPermissions, $permissions);
        } else {
            $this->selectedPermissions = array_unique(array_merge($this->selectedPermissions, $permissions));
        }
    }

    public function render()
    {
        return view('livewire.roles.edit');
    }
}
