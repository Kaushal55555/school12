<!-- Top Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">
        <!-- Toggle Sidebar Button (Visible on mobile) -->
        <button class="btn btn-link text-dark p-0 me-3 d-md-none" id="sidebarToggle">
            <i class="bi bi-list fs-4"></i>
        </button>
        
        <!-- Brand/Logo -->
        <a class="navbar-brand d-none d-md-block" href="{{ route('dashboard') }}">
            <i class="bi bi-mortarboard-fill text-primary me-2"></i>
            <span class="fw-bold">School</span> Result Management
        </a>
        
        <!-- Search Bar -->
        <div class="d-none d-md-block ms-3 flex-grow-1">
            <div class="input-group">
                <input type="text" class="form-control border-end-0" placeholder="Search..." id="globalSearch">
                <button class="btn btn-outline-secondary border-start-0" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
        
        <!-- Right Navigation Items -->
        <div class="d-flex align-items-center">
            @guest
                <!-- Guest Navigation -->
                <div class="d-flex align-items-center">
                    <a href="{{ route('teacher.login') }}" class="btn btn-outline-primary me-2">
                        Teacher Login
                    </a>
                    <a href="{{ route('teacher.register') }}" class="btn btn-primary">
                        Teacher Register
                    </a>
                </div>
            @else
                <!-- Authenticated User Navigation -->
                <!-- Notifications Dropdown -->
            <div class="dropdown me-3">
                <a class="position-relative text-dark" href="#" role="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        3
                        <span class="visually-hidden">unread notifications</span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start p-0" aria-labelledby="notificationsDropdown">
                    <div class="dropdown-header bg-light">
                        <h6 class="m-0">Notifications</h6>
                    </div>
                    <div class="dropdown-divider m-0"></div>
                    <a href="#" class="dropdown-item d-flex align-items-center p-3">
                        <div class="me-3">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-circle">
                                <i class="bi bi-person-plus text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="small">5 new students registered</div>
                            <small class="text-muted">10 minutes ago</small>
                        </div>
                    </a>
                    <div class="dropdown-divider m-0"></div>
                    <a href="#" class="dropdown-item d-flex align-items-center p-3">
                        <div class="me-3">
                            <div class="bg-success bg-opacity-10 p-2 rounded-circle">
                                <i class="bi bi-check-circle text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="small">Results for Class 10 published</div>
                            <small class="text-muted">2 hours ago</small>
                        </div>
                    </a>
                    <div class="dropdown-divider m-0"></div>
                    <a href="#" class="dropdown-item text-center py-2 small text-primary">
                        View all notifications
                    </a>
                </div>
            </div>
            
            <!-- Messages Dropdown -->
            <div class="dropdown me-3 d-none d-lg-block">
                <a class="text-dark" href="#" role="button" id="messagesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-envelope fs-5"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="messagesDropdown">
                    <div class="dropdown-header bg-light">
                        <h6 class="m-0">Messages</h6>
                    </div>
                    <div class="dropdown-divider m-0"></div>
                    <a href="#" class="dropdown-item d-flex align-items-center p-3">
                        <div class="position-relative me-3">
                            <img src="https://ui-avatars.com/api/?name=John+Doe&background=4e73df&color=fff" class="rounded-circle" width="40" height="40" alt="User">
                            <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle" style="width: 10px; height: 10px;"></span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0">John Doe</h6>
                                <small class="text-muted">5m ago</small>
                            </div>
                            <p class="small text-truncate mb-0" style="max-width: 200px;">Hello, I have a question about the results...</p>
                        </div>
                    </a>
                    <div class="dropdown-divider m-0"></div>
                    <a href="#" class="dropdown-item text-center py-2 small text-primary">
                        Read all messages
                    </a>
                </div>
            </div>
            
            @if(auth()->user()->hasRole('teacher'))
            <!-- Teacher Dropdown -->
            <div class="dropdown">
                <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" id="teacherDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="me-2 d-none d-lg-block text-end">
                        <div class="fw-medium">{{ Auth::user()->name }}</div>
                        <small class="text-muted">Teacher</small>
                    </div>
                    <div class="avatar-sm rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-fill text-primary"></i>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="teacherDropdown">
                    <li><a class="dropdown-item" href="{{ route('teacher.profile') }}"><i class="bi bi-person me-2"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('teacher.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('teacher.logout') }}" class="mb-0">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            @else
            <!-- Regular User Dropdown -->
            <div class="dropdown">
                <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="me-2 d-none d-lg-block text-end">
                        <div class="fw-medium">{{ Auth::user()->name ?? 'User' }}</div>
                        <small class="text-muted">
                            @if(Auth::user()->roles->isNotEmpty())
                                {{ Auth::user()->roles->first()->name }}
                            @else
                                User
                            @endif
                        </small>
                    </div>
                    <div class="avatar-sm rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-fill text-primary"></i>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="mb-0">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            @endif
            @endguest
        </div>
    </div>
</nav>

<!-- Mobile Search (Hidden on larger screens) -->
<div class="d-md-none bg-light p-3 border-bottom">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search...">
        <button class="btn btn-outline-secondary" type="button">
            <i class="bi bi-search"></i>
        </button>
    </div>
</div>
