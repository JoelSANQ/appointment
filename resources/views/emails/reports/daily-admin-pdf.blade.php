<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte detallado de citas</title>
    <style>
        body { font-family: sans-serif; line-height: 1.4; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; }
        .header h1 { color: #4f46e5; margin-bottom: 5px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #e5e7eb; padding: 10px; font-size: 11px; text-align: left; }
        .table th { background: #f3f4f6; font-weight: bold; }
        .footer { text-align: center; font-size: 10px; color: #9ca3af; margin-top: 20px; border-top: 1px solid #e5e7eb; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE DIARIO DE CITAS</h1>
        <p>Fecha: <strong>{{ $date }}</strong></p>
    </div>

    <p>En total, se han procesado {{ $appointments->count() }} citas programadas para hoy.</p>

    <table class="table">
        <thead>
            <tr>
                <th>Hora</th>
                <th>Paciente</th>
                <th>Doctor</th>
                <th>Estado</th>
                <th>Motivo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr>
                <td>{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</td>
                <td>{{ $appointment->patient->user->name }}</td>
                <td>{{ $appointment->doctor->user->name }}</td>
                <td><strong>{{ $appointment->status }}</strong></td>
                <td>{{ $appointment->reason ?? 'No especificado' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        &copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
    </div>
</body>
</html>
