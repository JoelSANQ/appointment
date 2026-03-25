<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Cita Programada - {{ config('app.name') }}</title>
    <style>
        body { font-family: sans-serif; line-height: 1.5; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4f46e5; color: #fff; padding: 20px; border-radius: 8px 8px 0 0; text-align: center; }
        .content { padding: 20px; border: 1px solid #e5e7eb; border-radius: 0 0 8px 8px; }
        .footer { text-align: center; font-size: 12px; color: #9ca3af; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nueva Cita Asignada</h1>
        </div>
        <div class="content">
            <p>Hola Dr. <strong>{{ $appointment->doctor->user->name }}</strong>,</p>
            <p>Se ha registrado una nueva cita médica en su agenda.</p>
            <p><strong>Detalles del Paciente:</strong></p>
            <ul>
                <li><strong>Nombre:</strong> {{ $appointment->patient->user->name }}</li>
                <li><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</li>
                <li><strong>Hora:</strong> {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</li>
                <li><strong>Motivo:</strong> {{ $appointment->reason ?? 'No especificado' }}</li>
            </ul>
            <p>Se adjunta a este correo el comprobante PDF de la cita.</p>
            <p>Atentamente,<br>El sistema de {{ config('app.name') }}</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
