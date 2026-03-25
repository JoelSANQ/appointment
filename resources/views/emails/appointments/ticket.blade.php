<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Cita</title>
    <style>
        body { font-family: sans-serif; line-height: 1.5; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #10b981; color: #fff; padding: 20px; border-radius: 8px 8px 0 0; text-align: center; }
        .content { padding: 20px; border: 1px solid #e5e7eb; border-radius: 0 0 8px 8px; }
        .footer { text-align: center; font-size: 12px; color: #9ca3af; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Cita Confirmada</h1>
        </div>
        <div class="content">
            <p>Hola <strong>{{ $appointment->patient->user->name }}</strong>,</p>
            <p>Tu cita médica ha sido registrada exitosamente.</p>
            <p>Se adjunta a este correo el ticket detallado de tu cita. Por favor, llévalo contigo el día de la consulta.</p>
            <p>Detalles rápidos:</p>
            <ul>
                <li><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</li>
                <li><strong>Hora:</strong> {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</li>
                <li><strong>Doctor:</strong> Dr. {{ $appointment->doctor->user->name ?? 'No especificado' }}</li>
            </ul>
            <p>Atentamente,<br>El equipo de {{ config('app.name') }}</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
