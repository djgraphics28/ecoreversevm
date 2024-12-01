<div>
    <!-- Content Row -->
    <div class="row">

        <!-- Total List of Students Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total List of Students</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStudents }}</div>
                            <!-- Replace with dynamic data -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total List of Faculties Card -->
        @if (Auth::user()->is_admin)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total List of Faculties</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalFaculties }}</div>
                                <!-- Replace with dynamic data -->
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Mission and Vision Section -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mission and Vision</h6>
                </div>
                <div class="card-body">
                    <h5 class="font-weight-bold text-gray-800">Mission:</h5>
                    {{-- <p>{{ $missionVision->mission }}</p> <!-- Replace with dynamic data --> --}}
                    <p>{{ $mission }}</p> <!-- Replace with dynamic data -->

                    <h5 class="font-weight-bold text-gray-800">Vision:</h5>
                    {{-- <p>{{ $missionVision->vision }}</p> <!-- Replace with dynamic data --> --}}
                    <p>{{ $vision }}</p> <!-- Replace with dynamic data -->
                </div>
            </div>
        </div>

    </div>
</div>
