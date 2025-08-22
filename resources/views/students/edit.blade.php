@extends('layouts.app')

@section('title', 'Edit Student: ' . $student->name)
@section('header', 'Edit Student: ' . $student->name)

@push('styles')
<style>
    .form-label {
        font-weight: 500;
        margin-bottom: 0.4rem;
    }
    .card {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.25rem 1.5rem;
    }
    .card-body {
        padding: 1.5rem;
    }
    .input-group-text {
        background-color: #f8f9fa;
    }
    .avatar-upload-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid #e9ecef;
    }
    .avatar-upload-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Edit Student Information</h5>
                    <p class="text-muted mb-0">Update the details below to modify student information</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('students.update', $student) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-uppercase text-muted mb-3">Personal Information</h6>
                            </div>
                            
                            <!-- Full Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $student->name) }}" 
                                               placeholder="Enter student's full name" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $student->email) }}" 
                                               placeholder="student@example.com" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Roll Number -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="roll_number" class="form-label">Roll Number <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-123"></i></span>
                                        <input type="text" class="form-control @error('roll_number') is-invalid @enderror" 
                                               id="roll_number" name="roll_number" value="{{ old('roll_number', $student->roll_number) }}" 
                                               placeholder="Enter roll number" required>
                                        @error('roll_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Class -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="class_id" class="form-label">Class <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-building"></i></span>
                                        <select class="form-select @error('class_id') is-invalid @enderror" 
                                                id="class_id" name="class_id" required>
                                            <option value="">Select Class</option>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('class_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-uppercase text-muted mb-3">Additional Information</h6>
                            </div>
                            
                            <!-- Date of Birth -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                               id="date_of_birth" name="date_of_birth" 
                                               value="{{ old('date_of_birth', $student->date_of_birth) }}" required>
                                        @error('date_of_birth')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Gender -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                                        <select class="form-select @error('gender') is-invalid @enderror" 
                                                id="gender" name="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Parent/Guardian Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="parent_name" class="form-label">Parent/Guardian Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                        <input type="text" class="form-control @error('parent_name') is-invalid @enderror" 
                                               id="parent_name" name="parent_name" 
                                               value="{{ old('parent_name', $student->parent_name) }}" 
                                               placeholder="Parent/Guardian full name">
                                        @error('parent_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Parent/Guardian Phone -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="parent_phone" class="form-label">Parent/Guardian Phone</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                        <input type="text" class="form-control @error('parent_phone') is-invalid @enderror" 
                                               id="parent_phone" name="parent_phone" 
                                               value="{{ old('parent_phone', $student->parent_phone) }}" 
                                               placeholder="+1 (555) 123-4567">
                                        @error('parent_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Address -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="address" class="form-label">Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                               id="address" name="address" 
                                               value="{{ old('address', $student->address) }}" 
                                               placeholder="123 Main St, City, Country">
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-uppercase text-muted mb-3">Profile Photo</h6>
                            </div>
                            
                            <!-- Profile Photo Upload -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="photo" class="form-label">Update Photo</label>
                                    <div class="file-upload">
                                        <div class="file-upload-content">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar-upload-preview" id="photoPreview">
                                                        @if($student->photo_path)
                                                            <img src="{{ asset('storage/' . $student->photo_path) }}" 
                                                                 alt="Current Photo" class="img-thumbnail rounded-circle" 
                                                                 style="width: 100px; height: 100px; object-fit: cover;">
                                                        @else
                                                            <img src="{{ asset('images/default-avatar.png') }}" 
                                                                 alt="Default Avatar" class="img-thumbnail rounded-circle" 
                                                                 style="width: 100px; height: 100px; object-fit: cover;">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="custom-file">
                                                        <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                                               id="photo" name="photo" accept="image/*" 
                                                               onchange="previewImage(this, 'photoPreview')">
                                                        <label class="custom-file-label" for="photo">Choose file</label>
                                                        <div class="form-text">Max file size: 2MB. Allowed formats: JPG, PNG, GIF. Leave blank to keep current photo.</div>
                                                        @error('photo')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                            <a href="{{ route('students.show', $student) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Back to Profile
                            </a>
                            <div class="d-flex gap-2">
                                <button type="reset" class="btn btn-outline-danger">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Update Student
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Image preview function
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">`;
        }
        
        if (file) {
            reader.readAsDataURL(file);
        } else {
            // If no file is selected, show the default image
            preview.innerHTML = `<img src="{{ $student->photo_path ? asset('storage/' . $student->photo_path) : asset('images/default-avatar.png') }}" 
                                   class="img-thumbnail rounded-circle" 
                                   style="width: 100%; height: 100%; object-fit: cover;">`;
        }
    }
    
    // Form validation
    (function () {
        'use strict'
        
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')
        
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
@endpush
@endsection