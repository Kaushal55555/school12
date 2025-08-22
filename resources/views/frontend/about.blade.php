@extends('layouts.frontend')

@section('title', 'About Us')

@section('content')
<!-- Page Header -->
<section class="page-header bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="fw-bold">About Our School</h1>
                <nav aria-label="breadcrumb" class="d-flex justify-content-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">About</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h2 class="fw-bold mb-4">Welcome to Our School</h2>
                <p class="lead">Empowering students to achieve excellence in education and beyond.</p>
                <p>Founded in 1990, our school has been a cornerstone of academic excellence and character development for over three decades. We are committed to providing a nurturing environment where students can grow intellectually, emotionally, and socially.</p>
                <p>Our dedicated faculty members are experts in their fields, bringing passion and innovation to the classroom every day. We believe in fostering a love for learning that extends beyond the classroom walls.</p>
                
                <div class="row mt-4 g-4">
                    <div class="col-md-6">
                        <div class="d-flex">
                            <div class="me-3 text-primary">
                                <i class="bi bi-mortarboard-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="h6 fw-bold mb-1">Qualified Teachers</h5>
                                <p class="mb-0 small">Our experienced educators are dedicated to student success.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex">
                            <div class="me-3 text-primary">
                                <i class="bi bi-book-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="h6 fw-bold mb-1">Modern Curriculum</h5>
                                <p class="mb-0 small">Comprehensive and up-to-date educational programs.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex">
                            <div class="me-3 text-primary">
                                <i class="bi bi-trophy-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="h6 fw-bold mb-1">Achievements</h5>
                                <p class="mb-0 small">Consistently high academic and extracurricular achievements.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex">
                            <div class="me-3 text-primary">
                                <i class="bi bi-people-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="h6 fw-bold mb-1">Inclusive Community</h5>
                                <p class="mb-0 small">Welcoming environment for all students and families.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-image-container h-100">
                    <img src="{{ asset('images/school Building.jpg') }}" 
                         alt="School Building" 
                         class="img-fluid">
                    <div class="about-badge">
                        <h3 class="fw-bold">30+</h3>
                        <p>Years of Excellence</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-bullseye fs-3"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">Our Mission</h3>
                        <p class="mb-0">To provide a transformative educational experience that prepares students to be responsible, compassionate, and innovative leaders in a rapidly changing world. We are committed to academic excellence, character development, and fostering a lifelong love of learning.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-eye-fill fs-3"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">Our Vision</h3>
                        <p class="mb-0">To be a leading educational institution recognized for nurturing well-rounded individuals who excel academically, think critically, and contribute meaningfully to society. We envision a community where every student discovers their potential and develops the skills to make a positive impact.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Values -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Core Values</h2>
            <p class="lead text-muted">Guiding principles that shape our school community</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="icon-lg bg-soft-primary text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4 class="h5 fw-bold">Excellence</h4>
                        <p class="mb-0">We strive for the highest standards in all aspects of education and personal development.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="icon-lg bg-soft-success text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <h4 class="h5 fw-bold">Integrity</h4>
                        <p class="mb-0">We uphold honesty, respect, and ethical behavior in all our interactions.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="icon-lg bg-soft-warning text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h4 class="h5 fw-bold">Community</h4>
                        <p class="mb-0">We foster a supportive and inclusive environment that values diversity.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Join Our School Community</h2>
        <p class="lead mb-4">Discover how we can help your child achieve their full potential.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('contact') }}" class="btn btn-light btn-lg px-4">
                <i class="bi bi-envelope me-2"></i> Contact Us
            </a>
            <a href="#" class="btn btn-outline-light btn-lg px-4">
                <i class="bi bi-calendar-check me-2"></i> Schedule a Visit
            </a>
        </div>
    </div>
</section>
@endsection
