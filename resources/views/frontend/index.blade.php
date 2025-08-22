@extends('layouts.frontend')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5 py-lg-7">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0 hero-content">
                <h1 class="display-4 fw-bold mb-4">Welcome to School Result Management System</h1>
                <p class="lead mb-4">Easily access and manage student results with our comprehensive school result management system.</p>
                <div class="hero-buttons">
                    <a href="{{ route('public.results') }}" class="btn btn-light btn-lg px-4">
                        <i class="bi bi-search me-2"></i> Check Results
                    </a>
                    @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Admin Login
                    </a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center">
                <img src="{{ asset('images/hero-image.png') }}" alt="Students learning" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Features</h2>
            <p class="text-muted">Everything you need to manage school results efficiently</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                            <i class="bi bi-speedometer2 fs-3"></i>
                        </div>
                        <h5 class="card-title">Easy to Use</h5>
                        <p class="card-text text-muted">Intuitive interface designed for both teachers and students to access results with ease.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                            <i class="bi bi-shield-lock fs-3"></i>
                        </div>
                        <h5 class="card-title">Secure Access</h5>
                        <p class="card-text text-muted">Robust security measures to protect student data and ensure privacy.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                            <i class="bi bi-graph-up fs-3"></i>
                        </div>
                        <h5 class="card-title">Detailed Reports</h5>
                        <p class="card-text text-muted">Generate comprehensive reports and analytics for better insights.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="bg-light py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">How to Check Results</h2>
            <p class="text-muted">Get your results in just a few simple steps</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px; font-size: 1.5rem; font-weight: bold;">1</div>
                    <h5>Enter Your Details</h5>
                    <p class="text-muted">Provide your roll number, class, and date of birth.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px; font-size: 1.5rem; font-weight: bold;">2</div>
                    <h5>Submit Information</h5>
                    <p class="text-muted">Click on the 'Check Result' button to proceed.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px; font-size: 1.5rem; font-weight: bold;">3</div>
                    <h5>View Results</h5>
                    <p class="text-muted">Access your detailed results and performance analysis.</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('public.results') }}" class="btn btn-primary btn-lg px-4">
                <i class="bi bi-search me-2"></i> Check Your Results Now
            </a>
        </div>
    </div>
</section>

<!-- Announcements -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0"><i class="bi bi-megaphone-fill text-primary me-2"></i> Latest Announcements</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Term 1 Results Published</h6>
                                    <small class="text-muted">3 days ago</small>
                                </div>
                                <p class="mb-1">The results for Term 1 have been published. Students can check their results online.</p>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Parent-Teacher Meeting</h6>
                                    <small class="text-muted">1 week ago</small>
                                </div>
                                <p class="mb-1">Scheduled for next Saturday. Please confirm your attendance.</p>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Annual Sports Day</h6>
                                    <small class="text-muted">2 weeks ago</small>
                                </div>
                                <p class="mb-1">Join us for our annual sports day event next month.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="bg-primary text-white py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Ready to Check Your Results?</h2>
        <p class="lead mb-4">Get instant access to your academic performance and track your progress.</p>
        <a href="{{ route('public.results') }}" class="btn btn-light btn-lg px-5">
            <i class="bi bi-search me-2"></i> Check Results Now
        </a>
    </div>
</section>
@endsection
