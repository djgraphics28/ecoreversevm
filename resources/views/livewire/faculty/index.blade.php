<div>
    @section('title', 'Manage Faculty')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Manage Faculty') }}</h1>

        <button wire:click="openModal" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Create New Faculty
        </button>
    </div>

    <!-- Search Input -->
    <div class="mb-4">
        <input type="text" wire:model.live="searchTerm" class="form-control" placeholder="Search for Faculty...">
    </div>

    <!-- Faculty Table -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Faculty List') }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Gender') }}</th>
                            <th>{{ __('Has User Access?') }}</th>
                            <th width="25%">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($faculties as $faculty)
                            <tr wire:key="{{ $faculty->id }}">
                                <td>{{ $faculty->id }}</td>
                                <td>
                                    <img id="image"
                                        src="{{ $faculty->getFirstMediaUrl('profile') ?: 'https://via.placeholder.com/150' }}"
                                        alt="image" class="img-thumbnail" width="50" height="50">
                                </td>
                                <td>{{ $faculty->full_name }}</td>
                                <td>{{ $faculty->gender }}</td>
                                <td>{{ !is_null($faculty->user_id) ? 'Yes' : 'No' }}</td>
                                <td>
                                    <button wire:click="openModal({{ $faculty->id }})" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button wire:click="deleteFaculty({{ $faculty->id }})"
                                        class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                    @if (is_null($faculty->user_id))
                                        <button wire:click="createUserAccount({{ $faculty->id }})"
                                            class="btn btn-sm btn-success">
                                            <i class="fas fa-user-plus"></i> Create User Account
                                        </button>
                                    @else
                                        <button wire:click="resetAccount({{ $faculty->id }})"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-sync"></i> Reset Account
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">{{ __('No Faculty found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-3">
                {{ $faculties->links() }}
            </div>
        </div>
    </div>

    @if ($modalOpen)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $facultyId ? __('Edit Faculty') : __('Create Faculty') }}</h5>
                        <button type="button" class="close" wire:click="$set('modalOpen', false)">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="title">{{ __('Title') }}</label>
                                <input type="text" id="title" wire:model.defer="title"
                                    class="form-control @error('title') is-invalid @enderror">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="first_name">{{ __('First Name') }}</label>
                                <input type="text" id="first_name" wire:model.defer="first_name"
                                    class="form-control @error('first_name') is-invalid @enderror">
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="middle_name">{{ __('Middle Name') }}</label>
                                <input type="text" id="middle_name" wire:model.defer="middle_name"
                                    class="form-control @error('middle_name') is-invalid @enderror">
                                @error('middle_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="last_name">{{ __('Last Name') }}</label>
                                <input type="text" id="last_name" wire:model.defer="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror">
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="gender">{{ __('Gender') }}</label>
                                <select id="gender" wire:model.defer="gender"
                                    class="form-control @error('gender') is-invalid @enderror">
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="male">{{ __('Male') }}</option>
                                    <option value="female">{{ __('Female') }}</option>
                                </select>
                                @error('gender')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input type="email" id="email" wire:model.defer="email"
                                    class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ __('Phone') }}</label>
                                <input type="text" id="phone" wire:model.defer="phone"
                                    class="form-control @error('phone') is-invalid @enderror">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="birth_date">{{ __('Birth Date') }}</label>
                                <input type="date" id="birth_date" wire:model.defer="birth_date"
                                    class="form-control @error('birth_date') is-invalid @enderror">
                                @error('birth_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image">{{ __('Faculty Image') }}</label>
                                <input type="file" id="image" wire:model="image"
                                    class="form-control-file @error('image') is-invalid @enderror">
                                @if ($image)
                                    <img src="{{ $image->temporaryUrl() }}" alt="Image Preview"
                                        class="img-thumbnail mt-2" width="150">
                                @elseif ($facultyId)
                                    <img src="{{ $faculties->find($facultyId)?->getFirstMediaUrl('profile', 'thumb') }}"
                                        alt="Image Preview" class="img-thumbnail mt-2" width="150">
                                @endif
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('modalOpen', false)">
                            {{ __('Cancel') }}
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="saveFaculty">
                            {{ $facultyId ? __('Update') : __('Save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
@endpush
