<!DOCTYPE html>
<html>
<head>
    <title>Print Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 20px;
                font-size: 12px;
            }
            .table {
                font-size: 11px;
            }
            h1 {
                font-size: 18px;
            }
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #000;
        }
        .filters {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="no-print text-end mb-3">
            <button onclick="window.print()" class="btn btn-primary">Print Results</button>
            <a href="{{ route('results.index') }}" class="btn btn-secondary">Back to Results</a>
        </div>

        <div class="header">
            <h1>School Results</h1>
            <p>Generated on: {{ now()->format('F j, Y h:i A') }}</p>
        </div>

        @if($results->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Subject</th>
                            <th>Marks</th>
                            <th>Grade</th>
                            <th>Percentage</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                            <tr>
                                <td>{{ $result->id }}</td>
                                <td>{{ $result->student->name }}</td>
                                <td>{{ $result->schoolClass->name }} ({{ $result->schoolClass->section }})</td>
                                <td>{{ $result->subject->name }} ({{ $result->subject->code }})</td>
                                <td>{{ $result->marks_obtained }}/{{ $result->subject->full_marks }}</td>
                                <td>{{ $result->grade }}</td>
                                <td>{{ $result->percentage }}%</td>
                                <td>{{ $result->remarks ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">No results found matching your criteria.</div>
        @endif
    </div>
</body>
</html>
