<!-- Sidebar -->
<div class="bg-primary text-white" id="sidebar-wrapper">
    <div class="sidebar-heading d-flex justify-content-between align-items-center px-3 py-4">
        <div class="d-flex align-items-center">
            <i class="bi bi-mortarboard-fill fs-4 me-2"></i>
            <span>School RMS</span>
        </div>
        <button class="btn btn-link text-white p-0 d-md-none" id="menu-toggle">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    
    <!-- Navigation -->
    <div class="list-group list-group-flush">
        @can('view dashboard')
        <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
        @endcan
        
        @canany(['view students', 'create students'])
        <a href="#studentsSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('students.*') ? 'true' : 'false' }}" class="list-group-item list-group-item-action {{ request()->routeIs('students.*') ? 'active' : '' }} dropdown-toggle">
            <i class="bi bi-people"></i> Students
        </a>
        <div class="collapse {{ request()->routeIs('students.*') ? 'show' : '' }}" id="studentsSubmenu">
            @can('create students')
            <a href="{{ route('students.create') }}" class="list-group-item list-group-item-action ps-4 {{ request()->routeIs('students.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Add Student
            </a>
            @endcan
            @can('view students')
            <a href="{{ route('students.index') }}" class="list-group-item list-group-item-action ps-4 {{ request()->routeIs('students.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i> View All Students
            </a>
            @endcan
        </div>
        @endcanany
        
        @canany(['view results', 'create results'])
        <a href="#resultsSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('results.*') ? 'true' : 'false' }}" class="list-group-item list-group-item-action {{ request()->routeIs('results.*') ? 'active' : '' }} dropdown-toggle">
            <i class="bi bi-journal-text"></i> Results
        </a>
        <div class="collapse {{ request()->routeIs('results.*') ? 'show' : '' }}" id="resultsSubmenu">
            @can('create results')
            <a href="{{ route('results.create') }}" class="list-group-item list-group-item-action ps-4 {{ request()->routeIs('results.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Add Result
            </a>
            @endcan
            @can('view results')
            <a href="{{ route('results.index') }}" class="list-group-item list-group-item-action ps-4 {{ request()->routeIs('results.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i> View All Results
            </a>
            @endcan
        </div>
        @endcanany
        
        @canany(['view subjects', 'create subjects'])
        <a href="#subjectsSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('subjects.*') ? 'true' : 'false' }}" class="list-group-item list-group-item-action {{ request()->routeIs('subjects.*') ? 'active' : '' }} dropdown-toggle">
            <i class="bi bi-book"></i> Subjects
        </a>
        <div class="collapse {{ request()->routeIs('subjects.*') ? 'show' : '' }}" id="subjectsSubmenu">
            @can('create subjects')
            <a href="{{ route('subjects.create') }}" class="list-group-item list-group-item-action ps-4 {{ request()->routeIs('subjects.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Add Subject
            </a>
            @endcan
            @can('view subjects')
            <a href="{{ route('subjects.index') }}" class="list-group-item list-group-item-action ps-4 {{ request()->routeIs('subjects.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i> View All Subjects
            </a>
            @endcan
        </div>
        @endcanany
        
        @canany(['view classes', 'create classes'])
        <a href="#classesSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('classes.*') ? 'true' : 'false' }}" class="list-group-item list-group-item-action {{ request()->routeIs('classes.*') ? 'active' : '' }} dropdown-toggle">
            <i class="bi bi-building"></i> Classes
        </a>
        <div class="collapse {{ request()->routeIs('classes.*') ? 'show' : '' }}" id="classesSubmenu">
            @can('create classes')
            <a href="{{ route('classes.create') }}" class="list-group-item list-group-item-action ps-4 {{ request()->routeIs('classes.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Add Class
            </a>
            @endcan
            @can('view classes')
            <a href="{{ route('classes.index') }}" class="list-group-item list-group-item-action ps-4 {{ request()->routeIs('classes.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i> View All Classes
            </a>
            @endcan
        </div>
        @endcanany
        
        @canany(['view teachers', 'create teachers'])
        <a href="#teachersSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('teachers.*') ? 'true' : 'false' }}" class="list-group-item list-group-item-action {{ request()->routeIs('teachers.*') ? 'active' : '' }} dropdown-toggle">
            <i class="bi bi-person-badge"></i> Teachers
        </a>
        <div class="collapse {{ request()->routeIs('teachers.*') ? 'show' : '' }}" id="teachersSubmenu">
            @can('create teachers')
            <a href="{{ route('teachers.create') }}" class="list-group-item list-group-item-action ps-4 {{ request()->routeIs('teachers.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Add Teacher
            </a>
            @endcan
            @can('view teachers')
            <a href="{{ route('teachers.index') }}" class="list-group-item list-group-item-action ps-4 {{ request()->routeIs('teachers.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i> View All Teachers
            </a>
            @endcan
        </div>
        @endcanany
        
        @can('manage school information')
        <a href="{{ route('admin.school-information.edit') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.school-information.*') ? 'active' : '' }}">
            <i class="bi bi-gear me-2"></i> School Information
        </a>
        @endcan
        
        @can('view subject assignments')
        <a href="{{ route('subject-assignments.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('subject-assignments.*') ? 'active' : '' }}">
            <i class="bi bi-journal-check me-2"></i> Subject Assignments
        </a>
        @endcan
        
        @can('view reports')
        <a href="#reportsSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('reports.*') ? 'true' : 'false' }}" class="list-group-item list-group-item-action {{ request()->routeIs('reports.*') ? 'active' : '' }} dropdown-toggle">
            <i class="bi bi-graph-up"></i> Reports
        </a>
        <div class="collapse {{ request()->routeIs('reports.*') ? 'show' : '' }}" id="reportsSubmenu">
            <a href="{{ route('reports.students') }}" class="list-group-item list-group-item-action ps-4 {{ request()->routeIs('reports.students') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Student Reports
            </a>
            <a href="{{ route('reports.results') }}" class="list-group-item list-group-item-action ps-4 {{ request()->routeIs('reports.results') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i> Result Analysis
            </a>
        </div>
        @endcan
    </div>
    
    <!-- User Section -->
    <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-dark">
        <div class="d-flex align-items-center">
            <div class="me-2">
                <div class="avatar-sm rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="bi bi-person-fill text-dark"></i>
                </div>
            </div>
            <div class="flex-grow-1 text-truncate">
                <div class="fw-medium">{{ Auth::user()->name ?? 'User' }}</div>
                <small class="text-white-50">{{ Auth::user()->email ?? 'user@example.com' }}</small>
            </div>
            <div class="ms-2">
                <a href="{{ route('logout') }}" class="text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
