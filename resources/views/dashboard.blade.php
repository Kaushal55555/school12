@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard Overview')

@section('content')
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Students Card -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card stat-card students h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-2">Total Students</h6>
                            <h2 class="mb-0">{{ $stats['total_students'] ?? 0 }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-people-fill text-primary fs-2"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success bg-opacity-10 text-success">
                            <i class="bi bi-arrow-up"></i> 12% from last month
                        </span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <a href="{{ route('students.index') }}" class="text-decoration-none small">
                        View all students <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Results Card -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card stat-card results h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-2">Results Published</h6>
                            <h2 class="mb-0">{{ $stats['total_results'] ?? 0 }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-journal-text text-warning fs-2"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success bg-opacity-10 text-success">
                            <i class="bi bi-arrow-up"></i> 5% from last term
                        </span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <a href="{{ route('results.index') }}" class="text-decoration-none small">
                        View all results <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Subjects Card -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card stat-card subjects h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-2">Total Subjects</h6>
                            <h2 class="mb-0">{{ $stats['total_subjects'] ?? 0 }}</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-book text-info fs-2"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-secondary bg-opacity-10 text-secondary">
                            <i class="bi bi-dash"></i> No change
                        </span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <a href="{{ route('subjects.index') }}" class="text-decoration-none small">
                        View all subjects <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Classes Card -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card stat-card classes h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-2">Classes</h6>
                            <h2 class="mb-0">{{ $stats['total_classes'] ?? 0 }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-building text-success fs-2"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success bg-opacity-10 text-success">
                            <i class="bi bi-plus"></i> 1 new this month
                        </span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <a href="#" class="text-decoration-none small">
                        View all classes <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row g-4">
        <!-- Recent Results -->
        <div class="col-12 col-xl-8">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Results</h5>
                    <a href="{{ route('results.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-lg me-1"></i> Add New
                    </a>
                </div>
                <div class="card-body p-0">
                    @if(isset($recentResults) && count($recentResults) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Student</th>
                                        <th>Subject</th>
                                        <th>Class</th>
                                        <th>Marks</th>
                                        <th>Term</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentResults as $result)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        <span class="avatar-initial rounded-circle bg-primary text-white">
                                                            {{ substr($result->student->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $result->student->name }}</h6>
                                                        <small class="text-muted">ID: {{ $result->student->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $result->subject->name ?? 'N/A' }}</td>
                                            <td>{{ $result->student->class->name ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $result->marks >= 40 ? 'success' : 'danger' }} bg-opacity-10 text-{{ $result->marks >= 40 ? 'success' : 'danger' }}">
                                                    {{ $result->marks }}%
                                                </span>
                                            </td>
                                            <td>{{ $result->term ?? 'N/A' }}</td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('results.show', $result->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('results.edit', $result->id) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete" onclick="confirmDelete('{{ route('results.destroy', $result->id) }}')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center p-5">
                            <div class="mb-3">
                                <i class="bi bi-journal-x fs-1 text-muted"></i>
                            </div>
                            <h5 class="text-muted">No results found</h5>
                            <p class="text-muted">Start by adding a new result to see it here.</p>
                            <a href="{{ route('results.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1"></i> Add Result
                            </a>
                        </div>
                    @endif
                </div>
                @if(isset($recentResults) && count($recentResults) > 0)
                    <div class="card-footer bg-white text-end">
                        <a href="{{ route('results.index') }}" class="btn btn-sm btn-outline-primary">
                            View All Results <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Quick Actions & Recent Activity -->
        <div class="col-12 col-xl-4">
            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('students.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                <i class="bi bi-person-plus text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Add New Student</h6>
                                <small class="text-muted">Register a new student</small>
                            </div>
                            <i class="bi bi-chevron-right ms-auto"></i>
                        </a>
                        <a href="{{ route('results.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 p-2 rounded me-3">
                                <i class="bi bi-journal-plus text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Record Results</h6>
                                <small class="text-muted">Add exam/test results</small>
                            </div>
                            <i class="bi bi-chevron-right ms-auto"></i>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 p-2 rounded me-3">
                                <i class="bi bi-file-earmark-bar-graph text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Generate Reports</h6>
                                <small class="text-muted">View and export reports</small>
                            </div>
                            <i class="bi bi-chevron-right ms-auto"></i>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                <i class="bi bi-gear text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">System Settings</h6>
                                <small class="text-muted">Configure system preferences</small>
                            </div>
                            <i class="bi bi-chevron-right ms-auto"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Activity</h5>
                    <a href="#" class="small">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @if(isset($recentActivities) && count($recentActivities) > 0)
                            @foreach($recentActivities as $activity)
                                <div class="list-group-item">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <div class="bg-{{ $activity['color'] }} bg-opacity-10 p-2 rounded-circle">
                                                <i class="bi bi-{{ $activity['icon'] }} text-{{ $activity['color'] }}"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-1">{{ $activity['description'] }}</p>
                                            <small class="text-muted">
                                                <i class="bi bi-clock me-1"></i> {{ $activity['time'] }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center p-4">
                                <i class="bi bi-activity fs-1 text-muted mb-3"></i>
                                <p class="text-muted mb-0">No recent activity</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add any additional sections or modals here -->
    
    @push('scripts')
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
        
        // Confirm delete function
        function confirmDelete(url) {
            if (confirm('Are you sure you want to delete this result? This action cannot be undone.')) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
    @endpush
@endsection
