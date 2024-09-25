<div>
    @section('title', 'Edit Role')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Edit Role') }}</h1>
        <a href="{{ route('roles.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back
        </a>
    </div>

    <div class="py-12 mb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Card for Role Editing -->
            <div class="card shadow">
                <div class="card-body">
                    <form wire:submit.prevent="updateRole">
                        <!-- Role Name -->
                        <div class="form-group">
                            <label for="role_name" class="form-label">Role Name</label>
                            <input type="text" id="role_name" wire:model="role_name" class="form-control">
                            @error('role_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <label for="">Select Permissions</label>

                        <!-- Grouped Permissions -->
                        <div class="form-group row">
                            @foreach ($this->groupedPermissions as $group => $permissions)
                                <div class="col-md-6">
                                    <div class="card mb-4 shadow">
                                        <div class="card-header bg-secondary text-white">
                                            <h5 class="font-weight-bold text-capitalize d-inline">{{ $group }}
                                            </h5>
                                            <div class="form-check d-inline float-right">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-all-{{ $group }}"
                                                    wire:click="toggleSelectAll('{{ $group }}')">
                                                <label class="form-check-label" for="select-all-{{ $group }}">
                                                    Select All
                                                </label>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach ($permissions as $permission)
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                wire:model="selectedPermissions"
                                                                value="{{ $permission->name }}"
                                                                id="permission-{{ $permission->id }}">
                                                            <label class="form-check-label"
                                                                for="permission-{{ $permission->id }}">
                                                                {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @error('selectedPermissions')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
