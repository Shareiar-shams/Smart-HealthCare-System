<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prescription #{{ $prescription->id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }
        .header .subtitle {
            font-size: 14px;
            color: #7f8c8d;
            margin: 5px 0;
        }
        .prescription-info {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .info-left, .info-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .info-section {
            margin-bottom: 15px;
        }
        .info-section h3 {
            margin: 0 0 8px 0;
            font-size: 14px;
            color: #2c3e50;
            border-bottom: 1px solid #bdc3c7;
            padding-bottom: 3px;
        }
        .info-item {
            margin-bottom: 3px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 80px;
        }
        .diagnosis {
            background: #ecf0f1;
            padding: 10px;
            margin: 15px 0;
            border-left: 4px solid #e74c3c;
        }
        .medicines {
            margin: 15px 0;
        }
        .medicine-item {
            background: #f8f9fa;
            padding: 8px;
            margin-bottom: 8px;
            border-left: 3px solid #3498db;
            border-radius: 3px;
        }
        .medicine-name {
            font-weight: bold;
            font-size: 13px;
        }
        .medicine-details {
            font-size: 11px;
            color: #666;
            margin-top: 2px;
        }
        .instructions {
            background: #fff3cd;
            padding: 10px;
            margin: 15px 0;
            border-left: 4px solid #ffc107;
        }
        .notes {
            background: #d4edda;
            padding: 10px;
            margin: 15px 0;
            border-left: 4px solid #28a745;
        }
        .signature {
            margin-top: 40px;
            text-align: right;
            border-top: 1px solid #333;
            padding-top: 20px;
        }
        .signature-line {
            width: 200px;
            display: inline-block;
            text-align: center;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #bdc3c7;
            padding-top: 10px;
        }
        @media print {
            body { padding: 10px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
        <div class="subtitle">Healthcare Management System</div>
        <div class="subtitle">Prescription #{{ $prescription->id }}</div>
    </div>

    <!-- Prescription Information -->
    <div class="prescription-info">
        <div class="info-left">
            <div class="info-section">
                <h3>Patient Information</h3>
                <div class="info-item">
                    <span class="info-label">Name:</span>
                    {{ $prescription->patient->name }}
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    {{ $prescription->patient->email }}
                </div>
                <div class="info-item">
                    <span class="info-label">Phone:</span>
                    {{ $prescription->patient->profile->contact_no ?? 'N/A' }}
                </div>
                @if($prescription->patient->profile->date_of_birth)
                    <div class="info-item">
                        <span class="info-label">Age:</span>
                        {{ \Carbon\Carbon::parse($prescription->patient->profile->date_of_birth)->age }} years
                    </div>
                @endif
                @if($prescription->patient->profile->blood_group)
                    <div class="info-item">
                        <span class="info-label">Blood Group:</span>
                        {{ $prescription->patient->profile->blood_group }}
                    </div>
                @endif
            </div>
        </div>

        <div class="info-right">
            <div class="info-section">
                <h3>Doctor Information</h3>
                <div class="info-item">
                    <span class="info-label">Name:</span>
                    Dr. {{ $prescription->doctor->user->name }}
                </div>
                <div class="info-item">
                    <span class="info-label">Specialty:</span>
                    {{ $prescription->doctor->specialty ?? 'General Medicine' }}
                </div>
                @if($prescription->doctor->qualification)
                    <div class="info-item">
                        <span class="info-label">Qualification:</span>
                        {{ $prescription->doctor->qualification }}
                    </div>
                @endif
                @if($prescription->doctor->license_number)
                    <div class="info-item">
                        <span class="info-label">License:</span>
                        {{ $prescription->doctor->license_number }}
                    </div>
                @endif
            </div>

            <div class="info-section">
                <h3>Appointment Details</h3>
                <div class="info-item">
                    <span class="info-label">Date:</span>
                    {{ $prescription->appointment->appointment_date ?
                       \Carbon\Carbon::parse($prescription->appointment->appointment_date)->format('M d, Y') :
                       \Carbon\Carbon::parse($prescription->appointment->start_at)->format('M d, Y') }}
                </div>
                <div class="info-item">
                    <span class="info-label">Time:</span>
                    {{ \Carbon\Carbon::parse($prescription->appointment->start_at)->format('h:i A') }} -
                    {{ \Carbon\Carbon::parse($prescription->appointment->end_at)->format('h:i A') }}
                </div>
                @if($prescription->appointment->reason)
                    <div class="info-item">
                        <span class="info-label">Reason:</span>
                        {{ $prescription->appointment->reason }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Diagnosis -->
    @if($prescription->diagnosis)
        <div class="diagnosis">
            <strong>Diagnosis:</strong><br>
            {{ $prescription->diagnosis }}
        </div>
    @endif

    <!-- Medicines -->
    @if($prescription->items && $prescription->items->count() > 0)
        <div class="medicines">
            <h3>Prescribed Medicines</h3>
            @foreach($prescription->items as $item)
                <div class="medicine-item">
                    <div class="medicine-name">{{ $item->medicine_name }}</div>
                    <div class="medicine-details">
                        Dosage: {{ $item->dosage }} |
                        Duration: {{ $item->duration }} |
                        Frequency: {{ $item->frequency }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Instructions -->
    @if($prescription->instructions)
        <div class="instructions">
            <strong>Instructions:</strong><br>
            {{ $prescription->instructions }}
        </div>
    @endif

    <!-- Notes -->
    @if($prescription->notes)
        <div class="notes">
            <strong>Additional Notes:</strong><br>
            {{ $prescription->notes }}
        </div>
    @endif

    <!-- Signature -->
    <div class="signature">
        <div class="signature-line">
            <strong>Dr. {{ $prescription->doctor->user->name }}</strong><br>
            {{ $prescription->doctor->specialty ?? 'General Medicine' }}<br>
            Date: {{ $prescription->created_at->format('M d, Y') }}
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>This prescription is valid for {{ $prescription->created_at->addDays(30)->format('M d, Y') }} |
        Generated on {{ $prescription->created_at->format('M d, Y \a\t h:i A') }}</p>
        <p>{{ config('app.name') }} - Healthcare Management System</p>
    </div>
</body>
</html>