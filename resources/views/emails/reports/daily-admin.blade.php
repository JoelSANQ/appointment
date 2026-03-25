<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Diario de Citas</title>
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
            <h1>Reporte Diario de Citas</h1>
        </div>
        <div class="content">
            <p>Hola,</p>
            <p>Se adjunta a este correo el reporte detallado de las citas programadas para el día <strong>{{ $date }}</strong>.</p>
            <p>En total, se han procesado {{ $appointments->count() }} citas.</p>
            <p>Por favor, revisa el archivo PDF adjunto para ver todos los detalles.</p>
            <p>Atentamente,<br>El equipo de {{ config('app.name') }}</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
