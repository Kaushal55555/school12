@php
    $currentYear = now()->format('Y');
    $nextYear = now()->addYear()->format('Y');
    $academicYear = "{$currentYear}-{$nextYear}";
    $isEdit = isset($subjectAssignment);
    $route = $isEdit ? route('subject-assignments.update', $subjectAssignment) : route('subject-assignments.store');
    $method = $isEdit ? 'PUT' : 'POST';
    $buttonText = $isEdit ? 'Update' : 'Create';
    
    // Get old input or model data
    $teacherId = old('teacher_id', $subjectAssignment->teacher_id ?? null);
    $classId = old('class_id', $subjectAssignment->class_id ?? null);
    $subjectId = old('subject_id', $subjectAssignment->subject_id ?? null);
    $academicYear = old('academic_year', $subjectAssignment->academic_year ?? $academicYear);
    $term = old('term', $subjectAssignment->term ?? null);
    $isClassTeacher = old('is_class_teacher', $subjectAssignment->is_class_teacher ?? 0);
@endphp

<form action="{{ $route }}" method="POST">
    @csrf
    @method($method)
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-group mb-3">
        <label for="teacher_id">Teacher <span class="text-danger">*</span></label>
        <select name="teacher_id" id="teacher_id" class="form-control select2" required>
            <option value="">Select Teacher</option>
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ $teacherId == $teacher->id ? 'selected' : '' }}>
                    {{ $teacher->user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="class_id">Class <span class="text-danger">*</span></label>
        <select name="class_id" id="class_id" class="form-control select2" required>
            <option value="">Select Class</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="subject_id">Subject <span class="text-danger">*</span></label>
        <select name="subject_id" id="subject_id" class="form-control select2" required>
            <option value="">Select Subject</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ $subjectId == $subject->id ? 'selected' : '' }}>
                    {{ $subject->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group mb-3">
                <label for="academic_year">Academic Year <span class="text-danger">*</span></label>
                <input type="text" name="academic_year" id="academic_year" class="form-control" 
                       value="{{ $academicYear }}" required 
                       placeholder="e.g., 2023-2024">
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="form-group mb-3">
                <label for="term">Term <span class="text-danger">*</span></label>
                <select name="term" id="term" class="form-control" required>
                    <option value="">Select Term</option>
                    <option value="First" {{ $term == 'First' ? 'selected' : '' }}>First Term</option>
                    <option value="Second" {{ $term == 'Second' ? 'selected' : '' }}>Second Term</option>
                    <option value="Third" {{ $term == 'Third' ? 'selected' : '' }}>Third Term</option>
                </select>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="form-group mb-3">
                <div class="form-check mt-4 pt-2">
                    <input type="checkbox" name="is_class_teacher" id="is_class_teacher" 
                           class="form-check-input" value="1" 
                           {{ $isClassTeacher ? 'checked' : '' }}>
                    <label for="is_class_teacher" class="form-check-label">Class Teacher</label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            {{ $buttonText }} Assignment
        </button>
        <a href="{{ route('subject-assignments.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
        });
        
        // Disable class teacher checkbox if the teacher is already a class teacher for this class in the same term/year
        function checkClassTeacherStatus() {
            const teacherId = $('select[name="teacher_id"]').val();
            const classId = $('select[name="class_id"]').val();
            const academicYear = $('input[name="academic_year"]').val();
            const term = $('select[name="term"]').val();
            
            if (teacherId && classId && academicYear && term) {
                $.get(`/api/check-class-teacher/${teacherId}/${classId}/${academicYear}/${term}`, function(data) {
                    const checkbox = $('#is_class_teacher');
                    if (data.is_class_teacher) {
                        checkbox.prop('checked', true);
                        checkbox.prop('disabled', false);
                    } else {
                        checkbox.prop('disabled', false);
                    }
                });
            }
        }
        
        $('select[name="teacher_id"], select[name="class_id"], input[name="academic_year"], select[name="term"]')
            .on('change', checkClassTeacherStatus);
    });
</script>
@endpush
