<div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <div class="text-center mb-4">
            @if(Auth::user()->profile_photo_path)
                <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" 
                     class="rounded-circle mb-2" 
                     alt="Profile" 
                     width="80" 
                     height="80">
            @else
                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mb-2" 
                     style="width: 80px; height: 80px; margin: 0 auto;">
                    <span class="text-white">{{ substr(Auth::user()->name, 0, 2) }}</span>
                </div>
            @endif
            <h6 class="mb-1">{{ Auth::user()->name }}</h6>
            <small class="text-muted">{{ Auth::user()->email }}</small>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}" 
                   href="{{ route('teacher.dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('teacher.classes.*') ? 'active' : '' }}" 
                   href="#" data-bs-toggle="collapse" data-bs-target="#classesCollapse">
                    <i class="bi bi-people me-2"></i>
                    My Classes
                </a>
                <div class="collapse {{ request()->routeIs('teacher.classes.*') ? 'show' : '' }}" id="classesCollapse">
                    <ul class="nav flex-column ms-4">
                        @foreach($classTeacherAssignments as $assignment)
                            <li class="nav-item">
                                <a class="nav-link" 
                                   href="{{ route('teacher.classes.students', $assignment->class_id) }}">
                                    {{ $assignment->schoolClass->name }} Students
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('teacher.subjects.*') ? 'active' : '' }}" 
                   href="#" data-bs-toggle="collapse" data-bs-target="#subjectsCollapse">
                    <i class="bi bi-book me-2"></i>
                    My Subjects
                </a>
                <div class="collapse {{ request()->routeIs('teacher.subjects.*') ? 'show' : '' }}" id="subjectsCollapse">
                    <ul class="nav flex-column ms-4">
                        @foreach($assignments->where('subject_id', '!=', null) as $assignment)
                            <li class="nav-item">
                                <a class="nav-link" 
                                   href="{{ route('teacher.subjects.students', ['class' => $assignment->class_id, 'subject' => $assignment->subject_id]) }}">
                                    {{ $assignment->subject->name }} ({{ $assignment->schoolClass->name }})
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('teacher.attendance.*') ? 'active' : '' }}" 
                   href="{{ route('teacher.attendance.index') }}">
                    <i class="bi bi-calendar-check me-2"></i>
                    Attendance
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('teacher.profile*') ? 'active' : '' }}" 
                   href="{{ route('teacher.profile') }}">
                    <i class="bi bi-person me-2"></i>
                    My Profile
                </a>
            </li>
        </ul>

        <hr>
        
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
