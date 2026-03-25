<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agenda del Día - Dr. {{ $doctor->user->name }}</title>
    <style>
        body { font-family: sans-serif; line-height: 1.4; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; }
        .header h1 { color: #4f46e5; margin-bottom: 5px; }
        .details { margin-bottom: 10px; font-size: 13px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #e5e7eb; padding: 10px; font-size: 11px; text-align: left; }
        .table th { background: #f3f4f6; font-weight: bold; }
        .footer { text-align: center; font-size: 10px; color: #9ca3af; margin-top: 20px; border-top: 1px solid #e5e7eb; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>AGENDA DEL DÍA</h1>
        <p>Doctor: <strong>{{ $doctor->user->name }}</strong></p>
        <p>Fecha: <strong>{{ $date }}</strong></p>
    </div>

    <div class="details">
        <p>Número de Citas para hoy: <strong>{{ $appointments->count() }}</strong></p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Hora</th>
                <th>Paciente</th>
                <th>Motivo / Notas</th>
                <th>DNI / ID No.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr>
                <td>{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</td>
                <td>{{ $appointment->patient->user->name }}</td>
                <td>{{ $appointment->reason ?? 'No especificado' }}</td>
                <td>{{ $appointment->patient->user->id_numero ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Este documento es para uso informativo interno del doctor. No compartir información de salud del paciente externamente.<br>
        &copy; {{ date('Y') }} {{ config('app.name') }}.
    </div>
</body>
</html>
