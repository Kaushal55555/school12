@extends('layouts.admin')

@section('title', 'School Information')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">School Information</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Update School Details</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.school-information.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Basic Information -->
                    <div class="col-md-6">
                        <h5 class="mb-3 text-primary">Basic Information</h5>
                        
                        <div class="form-group">
                            <label for="school_name">School Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('school_name') is-invalid @enderror" 
                                   id="school_name" name="school_name" 
                                   value="{{ old('school_name', $school->school_name ?? '') }}" required>
                            @error('school_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="school_code">School Code</label>
                            <input type="text" class="form-control @error('school_code') is-invalid @enderror" 
                                   id="school_code" name="school_code" 
                                   value="{{ old('school_code', $school->school_code ?? '') }}">
                            @error('school_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                     id="address" name="address" rows="3" required>{{ old('address', $school->address ?? '') }}</textarea>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" 
                                   value="{{ old('phone', $school->phone ?? '') }}" required>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" 
                                   value="{{ old('email', $school->email ?? '') }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="url" class="form-control @error('website') is-invalid @enderror" 
                                   id="website" name="website" 
                                   value="{{ old('website', $school->website ?? '') }}">
                            @error('website')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="col-md-6">
                        <h5 class="mb-3 text-primary">Contact Information</h5>
                        
                        <div class="form-group">
                            <label for="principal_name">Principal Name</label>
                            <input type="text" class="form-control @error('principal_name') is-invalid @enderror" 
                                   id="principal_name" name="principal_name" 
                                   value="{{ old('principal_name', $school->principal_name ?? '') }}">
                            @error('principal_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="contact_person_name">Contact Person Name</label>
                            <input type="text" class="form-control @error('contact_person_name') is-invalid @enderror" 
                                   id="contact_person_name" name="contact_person_name" 
                                   value="{{ old('contact_person_name', $school->contact_person_name ?? '') }}">
                            @error('contact_person_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="contact_person_phone">Contact Person Phone</label>
                            <input type="text" class="form-control @error('contact_person_phone') is-invalid @enderror" 
                                   id="contact_person_phone" name="contact_person_phone" 
                                   value="{{ old('contact_person_phone', $school->contact_person_phone ?? '') }}">
                            @error('contact_person_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="contact_person_email">Contact Person Email</label>
                            <input type="email" class="form-control @error('contact_person_email') is-invalid @enderror" 
                                   id="contact_person_email" name="contact_person_email" 
                                   value="{{ old('contact_person_email', $school->contact_person_email ?? '') }}">
                            @error('contact_person_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Logo and Favicon Upload -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="logo">School Logo</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('logo') is-invalid @enderror" 
                                               id="logo" name="logo" accept="image/*">
                                        <label class="custom-file-label" for="logo">Choose file</label>
                                        @error('logo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @if($school->logo_path ?? false)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $school->logo_path) }}" 
                                                 alt="School Logo" class="img-thumbnail" style="max-height: 100px;">
                                        </div>
                                    @endif
                                    <small class="form-text text-muted">Recommended size: 200x200px, Max: 2MB</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="favicon">Favicon</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('favicon') is-invalid @enderror" 
                                               id="favicon" name="favicon" accept=".ico,.png">
                                        <label class="custom-file-label" for="favicon">Choose file</label>
                                        @error('favicon')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @if($school->favicon_path ?? false)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $school->favicon_path) }}" 
                                                 alt="Favicon" class="img-thumbnail" style="max-height: 32px;">
                                        </div>
                                    @endif
                                    <small class="form-text text-muted">Recommended: .ico or .png, Max: 1MB</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Academic Settings -->
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3 text-primary">Academic Settings</h5>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="academic_year_start">Academic Year Start <span class="text-danger">*</span></label>
                                <select class="form-control @error('academic_year_start') is-invalid @enderror" 
                                       id="academic_year_start" name="academic_year_start" required>
                                    @php
                                        $months = [
                                            'January', 'February', 'March', 'April', 'May', 'June',
                                            'July', 'August', 'September', 'October', 'November', 'December'
                                        ];
                                        $currentStart = old('academic_year_start', $school->academic_year_start ?? 'January');
                                    @endphp
                                    @foreach($months as $month)
                                        <option value="{{ $month }}" {{ $currentStart == $month ? 'selected' : '' }}>
                                            {{ $month }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('academic_year_start')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="academic_year_end">Academic Year End <span class="text-danger">*</span></label>
                                <select class="form-control @error('academic_year_end') is-invalid @enderror" 
                                       id="academic_year_end" name="academic_year_end" required>
                                    @php
                                        $currentEnd = old('academic_year_end', $school->academic_year_end ?? 'December');
                                    @endphp
                                    @foreach($months as $month)
                                        <option value="{{ $month }}" {{ $currentEnd == $month ? 'selected' : '' }}>
                                            {{ $month }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('academic_year_end')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="timezone">Timezone <span class="text-danger">*</span></label>
                            <select class="form-control @error('timezone') is-invalid @enderror" 
                                   id="timezone" name="timezone" required>
                                @php
                                    $timezones = timezone_identifiers_list();
                                    $currentTimezone = old('timezone', $school->timezone ?? 'UTC');
                                @endphp
                                @foreach($timezones as $timezone)
                                    <option value="{{ $timezone }}" {{ $currentTimezone == $timezone ? 'selected' : '' }}>
                                        {{ $timezone }}
                                    </option>
                                @endforeach
                            </select>
                            @error('timezone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="mb-3 text-primary">Display Settings</h5>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="date_format">Date Format <span class="text-danger">*</span></label>
                                <select class="form-control @error('date_format') is-invalid @enderror" 
                                       id="date_format" name="date_format" required>
                                    @php
                                        $dateFormats = [
                                            'Y-m-d' => 'YYYY-MM-DD',
                                            'd/m/Y' => 'DD/MM/YYYY',
                                            'm/d/Y' => 'MM/DD/YYYY',
                                            'd-M-Y' => 'DD-MMM-YYYY',
                                            'M d, Y' => 'MMM DD, YYYY',
                                            'd F Y' => 'DD Month YYYY',
                                        ];
                                        $currentDateFormat = old('date_format', $school->date_format ?? 'Y-m-d');
                                    @endphp
                                    @foreach($dateFormats as $format => $label)
                                        <option value="{{ $format }}" {{ $currentDateFormat == $format ? 'selected' : '' }}>
                                            {{ $label }} ({{ now()->format($format) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('date_format')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="time_format">Time Format <span class="text-danger">*</span></label>
                                <select class="form-control @error('time_format') is-invalid @enderror" 
                                       id="time_format" name="time_format" required>
                                    @php
                                        $timeFormats = [
                                            'H:i' => '24-hour (14:30)',
                                            'h:i A' => '12-hour (02:30 PM)',
                                        ];
                                        $currentTimeFormat = old('time_format', $school->time_format ?? 'H:i');
                                    @endphp
                                    @foreach($timeFormats as $format => $label)
                                        <option value="{{ $format }}" {{ $currentTimeFormat == $format ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('time_format')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="currency">Currency <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('currency') is-invalid @enderror" 
                                       id="currency" name="currency" maxlength="3" 
                                       value="{{ old('currency', $school->currency ?? 'USD') }}" required>
                                @error('currency')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="currency_symbol">Currency Symbol <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('currency_symbol') is-invalid @enderror" 
                                       id="currency_symbol" name="currency_symbol" maxlength="5" 
                                       value="{{ old('currency_symbol', $school->currency_symbol ?? '$') }}" required>
                                @error('currency_symbol')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- About, Mission & Vision -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="about">About School</label>
                            <textarea class="form-control @error('about') is-invalid @enderror" 
                                     id="about" name="about" rows="5">{{ old('about', $school->about ?? '') }}</textarea>
                            @error('about')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mission">Mission</label>
                            <textarea class="form-control @error('mission') is-invalid @enderror" 
                                     id="mission" name="mission" rows="5">{{ old('mission', $school->mission ?? '') }}</textarea>
                            @error('mission')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="vision">Vision</label>
                            <textarea class="form-control @error('vision') is-invalid @enderror" 
                                     id="vision" name="vision" rows="5">{{ old('vision', $school->vision ?? '') }}</textarea>
                            @error('vision')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Social Media Links -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Social Media Links</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @php
                                $socialLinks = $school->social_links ?? [];
                            @endphp
                            
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-primary text-white">
                                                <i class="fab fa-facebook-f"></i>
                                            </span>
                                        </div>
                                        <input type="url" class="form-control" 
                                               name="social_facebook" 
                                               placeholder="https://facebook.com/yourpage"
                                               value="{{ old('social_facebook', $socialLinks['facebook'] ?? '') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-info text-white">
                                                <i class="fab fa-twitter"></i>
                                            </span>
                                        </div>
                                        <input type="url" class="form-control" 
                                               name="social_twitter" 
                                               placeholder="https://twitter.com/yourhandle"
                                               value="{{ old('social_twitter', $socialLinks['twitter'] ?? '') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-danger text-white">
                                                <i class="fab fa-youtube"></i>
                                            </span>
                                        </div>
                                        <input type="url" class="form-control" 
                                               name="social_youtube" 
                                               placeholder="https://youtube.com/yourchannel"
                                               value="{{ old('social_youtube', $socialLinks['youtube'] ?? '') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-instagram text-white">
                                                <i class="fab fa-instagram"></i>
                                            </span>
                                        </div>
                                        <input type="url" class="form-control" 
                                               name="social_instagram" 
                                               placeholder="https://instagram.com/yourprofile"
                                               value="{{ old('social_instagram', $socialLinks['instagram'] ?? '') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-linkedin text-white">
                                                <i class="fab fa-linkedin-in"></i>
                                            </span>
                                        </div>
                                        <input type="url" class="form-control" 
                                               name="social_linkedin" 
                                               placeholder="https://linkedin.com/company/yourcompany"
                                               value="{{ old('social_linkedin', $socialLinks['linkedin'] ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                           value="1" {{ (old('is_active', $school->is_active ?? false) ? 'checked' : '') }}>
                    <label class="form-check-label" for="is_active">Active</label>
                    <small class="form-text text-muted">Deactivating will hide this school information from the public site.</small>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-instagram {
        background: #f09433; 
        background: -moz-linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); 
        background: -webkit-linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); 
        background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); 
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f09433', endColorstr='#bc1888',GradientType=1 );
    }
    
    .bg-linkedin {
        background-color: #0077b5;
    }
    
    .custom-file-label::after {
        content: "Browse";
    }
    
    .img-thumbnail {
        max-width: 100%;
        height: auto;
    }
</style>
@endpush

@push('scripts')
<script>
    // Update the file input label with the selected file name
    document.querySelectorAll('.custom-file-input').forEach(function(input) {
        input.addEventListener('change', function(e) {
            let fileName = e.target.files[0] ? e.target.files[0].name : 'Choose file';
            let label = e.target.nextElementSibling;
            label.textContent = fileName;
            
            // Show preview for image files
            if (e.target.files && e.target.files[0]) {
                let reader = new FileReader();
                let previewId = e.target.id + '_preview';
                let previewElement = document.getElementById(previewId);
                
                if (!previewElement) {
                    previewElement = document.createElement('div');
                    previewElement.id = previewId;
                    previewElement.className = 'mt-2';
                    e.target.parentNode.parentNode.appendChild(previewElement);
                }
                
                if (e.target.files[0].type.match('image.*')) {
                    reader.onload = function(e) {
                        previewElement.innerHTML = '<img src="' + e.target.result + '" class="img-thumbnail" style="max-height: 100px;">';
                    }
                    reader.readAsDataURL(e.target.files[0]);
                } else {
                    previewElement.innerHTML = '';
                }
            }
        });
    });
    
    // Initialize any date/time pickers if needed
    document.addEventListener('DOMContentLoaded', function() {
        // You can add any initialization code here
    });
</script>
@endpush
