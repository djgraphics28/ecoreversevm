<div>
    @section('title', 'Create New Student')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Create New Student') }}</h1>
        <a href="{{ route('students.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back
        </a>
    </div>

    <div class="py-12 mb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Card for Student Creation -->
            <div class="card shadow">
                <div class="card-body">
                    <form wire:submit.prevent="createStudent">
                        <!-- Student Number -->
                        <div class="form-group">
                            <label for="student_number" class="form-label">Student Number</label>
                            <input type="text" id="student_number" wire:model="student_number" class="form-control"
                                required>
                            @error('student_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Student Number -->
                        <div class="form-group">
                            <label for="email" class="form-label">Student Email Address</label>
                            <input type="text" id="email" wire:model="email" class="form-control"
                                required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- RFID Code -->
                        <div class="form-group">
                            <label for="rfid_code" class="form-label">RFID Code</label>
                            <input type="text" id="rfid_code" wire:model="rfid_code" class="form-control" required>
                            @error('rfid_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- First Name -->
                        <div class="form-group">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" id="first_name" wire:model="first_name" class="form-control" required>
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Middle Name -->
                        <div class="form-group">
                            <label for="middle_name" class="form-label">Middle Name (Optional)</label>
                            <input type="text" id="middle_name" wire:model="middle_name" class="form-control">
                            @error('middle_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="form-group">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" id="last_name" wire:model="last_name" class="form-control" required>
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Birth Date -->
                        <div class="form-group">
                            <label for="birth_date" class="form-label">Birth Date</label>
                            <input type="date" id="birth_date" wire:model="birth_date" class="form-control" required>
                            @error('birth_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="form-group">
                            <label for="gender" class="form-label">Gender</label>
                            <select id="gender" wire:model="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            @error('gender')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Grade Level -->
                        <div class="form-group">
                            <label for="grade_level_id" class="form-label">Grade Level</label>
                            <select id="grade_level_id" wire:model="grade_level_id" class="form-control" required>
                                <option value="">Select Grade Level</option>
                                @foreach ($gradeLevels as $gradeLevel)
                                    <option value="{{ $gradeLevel->id }}">{{ $gradeLevel->name }}</option>
                                @endforeach
                            </select>
                            @error('grade_level_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Section -->
                        <div class="form-group">
                            <label for="section_id" class="form-label">Section</label>
                            <select id="section_id" wire:model="section_id" class="form-control" required>
                                <option value="">Select Section</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                @endforeach
                            </select>
                            @error('section_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Student Picture -->
                        <div class="mb-3">
                            <label for="student_picture" class="form-label">Student Picture</label>
                            <input id="student_picture" type="file" wire:model="student_picture" class="form-control"
                                accept="image/*" onchange="previewImage();" />

                            <!-- Display preview of the uploaded picture -->
                            <div class="mt-3">
                                <img id="profile_picture_preview"
                                    src="{{ $student_picture ? $student_picture->temporaryUrl() : 'https://via.placeholder.com/150' }}"
                                    alt="Student Picture" class="img-thumbnail" width="150" height="150">
                            </div>

                            @error('student_picture')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Student
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- JavaScript to handle image preview -->
<script>
    function previewImage() {
        const input = document.getElementById('student_picture');
        const preview = document.getElementById('profile_picture_preview');

        const file = input.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result; // Update the src attribute of the image
            };

            reader.readAsDataURL(file); // Read the file as a Data URL
        }
    }
</script>
