<div>
    @section('title', 'Edit Section')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Edit Section') }}</h1>
        <a href="{{ route('sections.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back
        </a>
    </div>

    <div class="py-12 mb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Card for Section Editing -->
            <div class="card shadow">
                <div class="card-body">
                    <form wire:submit.prevent="updateSection">
                        <!-- Section Name -->
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" wire:model="name" class="form-control">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                         <!-- Faculty Selection -->
                         <div class="form-group">
                            <label for="faculty" class="form-label">Faculty</label>
                            <select id="faculty" wire:model="faculty" class="form-control">
                                <option value="">Select Faculty</option>
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->id }}">{{ $faculty->title }} {{ $faculty->first_name }} {{ $faculty->last_name }}</option>
                                @endforeach
                            </select>
                            @error('faculty')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Section
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
