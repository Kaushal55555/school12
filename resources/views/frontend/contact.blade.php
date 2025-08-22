@extends('layouts.frontend')

@section('title', 'Contact Us')

@section('content')
<!-- Page Header -->
<section class="page-header bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="fw-bold">Contact Us</h1>
                <nav aria-label="breadcrumb" class="d-flex justify-content-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <div class="mb-5">
                    <h2 class="fw-bold mb-4">Get In Touch</h2>
                    <p class="lead">We'd love to hear from you! Send us a message and we'll respond as soon as possible.</p>
                </div>
                
                <!-- Contact Information -->
                <div class="mb-5">
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3 text-primary">
                            <i class="bi bi-geo-alt-fill fs-4"></i>
                        </div>
                        <div class="ms-4">
                            <h5 class="fw-bold mb-1">Our Location</h5>
                            <p class="mb-0">Lazimpat, Kathmandu 44600<br>Bagmati Province, Nepal</p>
                        </div>
                    </div>
                    
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3 text-primary">
                            <i class="bi bi-envelope-fill fs-4"></i>
                        </div>
                        <div class="ms-4">
                            <h5 class="fw-bold mb-1">Email Us</h5>
                            <p class="mb-0">info@schoolrms.edu.np<br>admission@schoolrms.edu.np</p>
                        </div>
                    </div>
                    
                    <div class="d-flex">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3 text-primary">
                            <i class="bi bi-telephone-fill fs-4"></i>
                        </div>
                        <div class="ms-4">
                            <h5 class="fw-bold mb-1">Call Us</h5>
                            <p class="mb-0">+977-1-4412345<br>+977-9801234567</p>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media -->
                <div>
                    <h5 class="fw-bold mb-3">Follow Us</h5>
                    <div class="d-flex gap-3">
                        <a href="https://facebook.com/schoolrmsnepal" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle" style="width: 40px; height: 40px; line-height: 40px; padding: 0;" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://twitter.com/schoolrmsnepal" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle" style="width: 40px; height: 40px; line-height: 40px; padding: 0;" title="Twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="https://instagram.com/schoolrmsnepal" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle" style="width: 40px; height: 40px; line-height: 40px; padding: 0;" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://youtube.com/@schoolrmsnepal" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle" style="width: 40px; height: 40px; line-height: 40px; padding: 0;" title="YouTube">
                            <i class="bi bi-youtube"></i>
                        </a>
                        <a href="#" class="btn btn-outline-primary btn-sm rounded-circle" style="width: 40px; height: 40px; line-height: 40px; padding: 0;">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Send Us a Message</h3>
                        
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        <form action="#" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Your Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                           id="subject" name="subject" value="{{ old('subject') }}" required>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Your Message <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" 
                                              id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bi bi-send-fill me-2"></i> Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-0">
    <div class="container-fluid p-0">
        <div class="ratio ratio-21x9">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.2152091793735!2d-73.9878449242641!3d40.7579859715928!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDQ1JzI4LjciTiA3M8KwNTknMTUuNyJX!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus" 
                    allowfullscreen="" loading="lazy" class="w-100"></iframe>
        </div>
    </div>
</section>

<!-- Contact Cards -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="icon-lg bg-soft-primary text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                            <i class="bi bi-headset"></i>
                        </div>
                        <h4 class="h5 fw-bold">Admission Inquiries</h4>
                        <p class="mb-0">admission@schoolrms.com<br>+1 234 567 8901</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="icon-lg bg-soft-success text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <h4 class="h5 fw-bold">General Inquiries</h4>
                        <p class="mb-0">info@schoolrms.com<br>+1 234 567 8900</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="icon-lg bg-soft-warning text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                            <i class="bi bi-clock"></i>
                        </div>
                        <h4 class="h5 fw-bold">Office Hours</h4>
                        <p class="mb-0">Monday - Friday: 8:00 AM - 4:00 PM<br>Saturday: 9:00 AM - 1:00 PM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Frequently Asked Questions</h2>
            <p class="lead text-muted">Find answers to common questions about our school</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h3 class="accordion-header" id="headingOne">
                            <button class="accordion-button bg-white fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                What are the school hours?
                            </button>
                        </h3>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Our regular school hours are from 8:00 AM to 3:00 PM, Monday through Friday. The school office is open from 7:30 AM to 4:30 PM on school days.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h3 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed bg-white fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                How can I apply for admission?
                            </button>
                        </h3>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                To apply for admission, please visit our admissions page or contact our admissions office at admission@schoolrms.com. You'll need to submit an application form, previous school records, and schedule an entrance examination and interview.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h3 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed bg-white fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                What extracurricular activities are available?
                            </button>
                        </h3>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We offer a wide range of extracurricular activities including sports (basketball, soccer, swimming), music and arts programs, debate club, science club, and community service opportunities. These activities help students develop their talents and interests beyond the classroom.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h3 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed bg-white fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                How can I check my child's academic progress?
                            </button>
                        </h3>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Parents can check their child's academic progress through our online portal. You'll receive login credentials at the beginning of the school year. The portal provides access to grades, attendance records, assignments, and teacher comments.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm rounded-3 overflow-hidden">
                        <h3 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed bg-white fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                What safety measures are in place?
                            </button>
                        </h3>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                The safety of our students is our top priority. We have implemented several safety measures including secure campus access, CCTV surveillance, trained security personnel, emergency response protocols, and regular safety drills. All visitors must check in at the front office and wear a visitor's badge while on campus.
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-5">
                    <p class="mb-4">Still have questions? We're here to help!</p>
                    <a href="mailto:info@schoolrms.com" class="btn btn-primary px-4">
                        <i class="bi bi-envelope me-2"></i> Email Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
