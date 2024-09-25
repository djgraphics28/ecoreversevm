<div>
    @section('title', 'List of Grade Levels')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('List of Grade Levels') }}</h1>
        @can('create grade level')
            <a href="{{ route('grade-levels.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Create New
            </a>
        @endcan
    </div>

    <!-- Search Input -->
    <div class="mb-4">
        <input type="text" wire:model.live="searchTerm" class="form-control" placeholder="Search for grade levels...">
    </div>

    <!-- Grade Level Table -->
    <div class="py-12 mb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Grade level List') }}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="gradeLevelsTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>{{ __('Grade Level') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($gradeLevels as $gradeLevel)
                                    <tr>
                                        <td>{{ $gradeLevel->id }}</td>
                                        <td>{{ $gradeLevel->name }}</td>
                                        <td>
                                            @can('edit grade level')
                                                <a href="{{ route('grade-levels.edit', $gradeLevel->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            @endcan
                                            @if ($gradeLevel->is_deleteable)
                                                @can('delete grade level')
                                                    <button wire:click="alertConfirm({{ $gradeLevel->id }})"
                                                        class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
                                                @endcan
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No Grade level found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-3">
                        {{ $gradeLevels->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
