<div>
    @section('title', 'List of Students')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('List of Students') }}</h1>
        @can('create students')
            <a href="{{ route('students.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Create New
            </a>
        @endcan
    </div>

    <!-- Search Input -->
    <div class="mb-4">
        <input type="text" wire:model.live="searchTerm" class="form-control" placeholder="Search for students...">
    </div>

    <!-- Student Table -->
    <div class="py-12 mb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Student List') }}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="studentsTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Picture</th>
                                    <th>{{ __('Student Number') }}</th>
                                    <th>{{ __('RFID Code') }}</th>
                                    <th>{{ __('First Name') }}</th>
                                    <th>{{ __('Middle Name') }}</th>
                                    <th>{{ __('Last Name') }}</th>
                                    <th>{{ __('Birth Date') }}</th>
                                    <th>{{ __('Gender') }}</th>
                                    <th>{{ __('Grade Level') }}</th>
                                    <th>{{ __('Section') }}</th>
                                    <th>{{ __('Points') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $student)
                                    <tr>
                                        <td>
                                            <img id="profile_picture_preview"
                                                src="{{ $student->getFirstMediaUrl('student_pictures') ?: 'https://via.placeholder.com/150' }}"
                                                alt="Student Picture" class="img-thumbnail" width="50"
                                                height="50">
                                        </td>
                                        <td>{{ $student->student_number }}</td>
                                        <td>{{ $student->rfid_code }}</td>
                                        <td>{{ $student->first_name }}</td>
                                        <td>{{ $student->middle_name }}</td>
                                        <td>{{ $student->last_name }}</td>
                                        <td>{{ $student->birth_date }}</td>
                                        <td>{{ $student->gender }}</td>
                                        <td>{{ $student->gradeLevel->name ?? 'N/A' }}</td>
                                        <td>{{ $student->section->name ?? 'N/A' }}</td>
                                        <td>{{ $student->points }}</td>
                                        <td>
                                            @can('edit students')
                                                <a href="{{ route('students.edit', $student->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            @endcan
                                            @can('delete students')
                                                <button wire:click="alertConfirm({{ $student->id }})"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12">No students found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-3">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
