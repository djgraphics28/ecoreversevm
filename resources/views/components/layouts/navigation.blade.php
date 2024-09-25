<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        {{-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> --}}
        <x-application-logo width="50px" class="w-24 h-24 fill-current text-gray-500" />
        <div class="sidebar-brand-text mx-3">Eco&nbsp;Reverse VM</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    @can('access dashboard')
        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
    @endcan

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Navigation
    </div>

    @can('access users')
        <!-- Nav Item - Users Collapse Menu -->
        <li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
                aria-expanded="{{ request()->is('users*') ? 'true' : 'false' }}" aria-controls="collapseUsers">
                <i class="fas fa-fw fa-users"></i>
                <span>Users</span>
            </a>
            <div id="collapseUsers" class="collapse {{ request()->is('users*') ? 'show' : '' }}"
                aria-labelledby="headingUsers" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">User Components:</h6>
                    <a class="collapse-item {{ request()->is('users') ? 'active' : '' }}"
                        href="{{ route('users.index') }}">List of Users</a>
                    @can('create users')
                        <a class="collapse-item {{ request()->is('users/create') ? 'active' : '' }}"
                            href="{{ route('users.create') }}">Create New User</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcan

    @can('access roles')
        <!-- Nav Item - FAQs Menu -->
        <li class="nav-item {{ request()->is('roles*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRolesAndPermissions"
                aria-expanded="true" aria-controls="collapseRolesAndPermissions">
                <i class="fas fa-fw fa-lock"></i>
                <span>Roles & Permissions</span>
            </a>
            <div id="collapseRolesAndPermissions" class="collapse {{ request()->is('roles*') ? 'show' : '' }}"
                aria-labelledby="headingFAQs" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Roles Components:</h6>
                    <a class="collapse-item {{ request()->is('roles') ? 'active' : '' }}"
                        href="{{ route('roles.index') }}">List of Roles</a>
                    @can('create roles')
                        <a class="collapse-item {{ request()->is('roles/create') ? 'active' : '' }}"
                            href="{{ route('roles.create') }}">Create New Role</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcan


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Student Info Management
    </div>

    @can('access students')
        <!-- Nav Item - FAQs Menu -->
        <li class="nav-item {{ request()->is('students*') || request()->is('grade-levels*') || request()->is('sections*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudents"
                aria-expanded="true" aria-controls="collapseStudents">
                <i class="fas fa-fw fa-users"></i>
                <span>Manage Students</span>
            </a>
            <div id="collapseStudents" class="collapse {{ request()->is('students*')  ||  request()->is('grade-levels*') || request()->is('sections*') ? 'show' : '' }}"
                aria-labelledby="headingStudents" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Student Component:</h6>
                    <a class="collapse-item {{ request()->is('students') ? 'active' : '' }}"
                        href="{{ route('students.index') }}">List of Students</a>
                    @can('create students')
                        <a class="collapse-item {{ request()->is('students/create') ? 'active' : '' }}"
                            href="{{ route('students.create') }}">Create New Student</a>
                    @endcan
                    <h6 class="collapse-header">Grade Level / Sections:</h6>
                    @can('access grade level')
                        <a class="collapse-item {{ request()->is('grade-levels*') ? 'active' : '' }}"
                            href="{{ route('grade-levels.index') }}">Grade Levels</a>
                    @endcan
                    @can('access section')
                        <a class="collapse-item {{ request()->is('sections*') ? 'active' : '' }}"
                            href="{{ route('sections.index') }}">Sections</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcan

    {{-- @can('access app settings')
        <!-- Nav Item - App settings -->
        <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-cogs"></i>
                <span>App Settings</span></a>
        </li>
    @endcan --}}



    <!-- Nav Item - Tables -->
    {{-- <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>



</ul>
