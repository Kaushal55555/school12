<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 250px;
        }
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
        }
        .sidebar {
            min-height: 100vh;
            width: var(--sidebar-width);
            background: #4e73df;
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            color: white;
            position: fixed;
            z-index: 1000;
        }
        #page-content-wrapper {
            min-width: 0;
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 1rem;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }
        .topbar {
            height: 4.375rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        .card {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4">
                <h4>School Result</h4>
                <p class="mb-0">Management System</p>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('students.index') }}" class="nav-link {{ request()->is('students*') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-user-graduate"></i>
                    <span>Students</span>
                </a>
                <a href="{{ route('classes.index') }}" class="nav-link {{ request()->is('classes*') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-school"></i>
                    <span>Classes</span>
                </a>
                <a href="{{ route('subjects.index') }}" class="nav-link {{ request()->is('subjects*') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Subjects</span>
                </a>
                <a href="{{ route('results.index') }}" class="nav-link {{ request()->is('results*') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-clipboard-list"></i>
                    <span>Results</span>
                </a>
                <a href="{{ route('reports.students') }}" class="nav-link {{ request()->is('reports*') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>Reports</span>
                </a>
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white topbar mb-4 static-top shadow">
                <div class="container-fluid">
                    <button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggle">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="me-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <i class="fas fa-user-circle fa-fw"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
                                    Profile
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid px-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('sidebar-wrapper').classList.toggle('d-none');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar-wrapper');
            const sidebarToggle = document.getElementById('sidebarToggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !sidebarToggle.contains(event.target)) {
                sidebar.classList.add('d-none');
            }
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
    @stack('scripts')
</body>
</html>
