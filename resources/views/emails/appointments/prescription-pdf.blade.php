<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Receta Médica</title>
    <style>
        body { font-family: sans-serif; line-height: 1.4; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; }
        .header h1 { color: #4f46e5; margin-bottom: 5px; }
        .info-section { margin-bottom: 20px; }
        .info-grid { width: 100%; border-collapse: collapse; }
        .info-grid td { padding: 5px 0; font-size: 14px; }
        .diagnosis-section { padding: 15px; background: #f9fafb; border-radius: 8px; margin-bottom: 20px; border: 1px solid #e5e7eb; }
        .diagnosis-title { font-weight: bold; color: #4f46e5; margin-bottom: 5px; font-size: 12px; text-transform: uppercase; }
        .medicines-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .medicines-table th, .medicines-table td { border-bottom: 1px solid #e5e7eb; padding: 12px 10px; text-align: left; }
        .medicines-table th { background: #f3f4f6; font-size: 12px; text-transform: uppercase; color: #6b7280; }
        .medicine-name { font-weight: bold; color: #111827; }
        .dosage { font-size: 13px; color: #4b5563; }
        .footer { text-align: center; font-size: 11px; color: #9ca3af; margin-top: 40px; border-top: 1px solid #e5e7eb; padding-top: 15px; }
        .signature { margin-top: 50px; text-align: right; }
        .signature-line { border-top: 1px solid #333; width: 200px; display: inline-block; margin-top: 40px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>RECETA MÉDICA</h1>
        <p>{{ config('app.name') }} - Atención Médica de Calidad</p>
    </div>

    <div class="info-section">
        <table class="info-grid">
            <tr>
                <td style="width: 50%"><strong>Paciente:</strong> {{ $appointment->patient->user->name }}</td>
                <td style="width: 50%; text-align: right;"><strong>Fecha:</strong> {{ date('d/m/Y') }}</td>
            </tr>
            <tr>
                <td><strong>Doctor:</strong> Dr. {{ $appointment->doctor->user->name }}</td>
                <td style="text-align: right;"><strong>Cita ID:</strong> #{{ $appointment->id }}</td>
            </tr>
        </table>
    </div>

    <div class="diagnosis-section">
        <div class="diagnosis-title">Diagnóstico</div>
        <p style="margin: 0; font-size: 14px;">{{ $appointment->consultation->diagnosis }}</p>
    </div>

    <div class="diagnosis-section">
        <div class="diagnosis-title">Tratamiento Recomendado</div>
        <p style="margin: 0; font-size: 14px;">{{ $appointment->consultation->treatment }}</p>
    </div>

    @if($appointment->consultation->prescriptionItems->count() > 0)
        <h3>Plan Farmacéutico</h3>
        <table class="medicines-table">
            <thead>
                <tr>
                    <th>Medicamento</th>
                    <th>Dosis</th>
                    <th>Frecuencia / Duración</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointment->consultation->prescriptionItems as $item)
                <tr>
                    <td class="medicine-name">{{ $item->medicine_name }}</td>
                    <td class="dosage">{{ $item->dosage }}</td>
                    <td class="dosage">{{ $item->frequency_duration }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($appointment->consultation->notes)
        <div style="margin-top: 20px;">
            <strong>Notas adicionales:</strong>
            <p style="font-size: 13px; color: #4b5563;">{{ $appointment->consultation->notes }}</p>
        </div>
    @endif

    <div class="signature">
        <div class="signature-line"></div>
        <p style="margin: 5px 0 0 0;">Dr. {{ $appointment->doctor->user->name }}</p>
        <p style="margin: 0; font-size: 10px; color: #9ca3af;">Firma y Sello</p>
    </div>

    <div class="footer">
        Esta receta tiene validez oficial bajo el soporte de {{ config('app.name') }}.<br>
        &copy; {{ date('Y') }} {{ config('app.name') }}.
    </div>
</body>
</html>
