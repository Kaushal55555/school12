<?php

namespace App\Exports;

use App\Models\SchoolClass;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class StudentsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle
{
    protected $class;

    public function __construct(SchoolClass $class)
    {
        $this->class = $class;
    }

    public function collection()
    {
        return $this->class->students()
            ->with('user')
            ->orderBy('roll_number')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Roll Number',
            'Student Name',
            'Email',
            'Phone',
            'Address',
            'Date of Birth',
            'Gender',
            'Admission Date',
            'Status'
        ];
    }

    public function map($student): array
    {
        return [
            $student->roll_number,
            $student->user->name,
            $student->user->email,
            $student->phone ?? 'N/A',
            $student->address ?? 'N/A',
            $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : 'N/A',
            ucfirst($student->gender) ?? 'N/A',
            $student->admission_date ? $student->admission_date->format('Y-m-d') : 'N/A',
            $student->is_active ? 'Active' : 'Inactive'
        ];
    }

    public function title(): string
    {
        return 'Class ' . $this->class->name . ' Students';
    }
}
