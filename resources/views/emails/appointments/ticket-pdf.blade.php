<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Cita</title>
    <style>
        body { font-family: sans-serif; line-height: 1.4; color: #333; }
        .header { text-align: center; 
                  margin-bottom: 20px;
                   border-bottom: 2px solid #10b981; 
                   padding-bottom: 10px;
                background-color: #10b981; }

        .header h1 { color: #fcfcfc; margin-bottom: 5px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table td { background:#525252; color:#fcfcfc;}
        .table th, .table td { border: 1px solid #e5e7eb; padding: 10px; font-size: 14px; text-align: left; }
        .table th { background: #f3f4f6; font-weight: bold; width: 30%; }
        .footer { text-align: center; font-size: 12px; color: #9ca3af; margin-top: 40px; border-top: 1px solid #e5e7eb; padding-top: 10px; }
        .image img { display: block;   margin: 0 auto; }
        img{opacity: 0.2;  text-align: center;}
        
    </style>
</head>
<body>
    <div class="header">
        <h1>TICKET DE CITA</h1>
        <p>Número de Cita: <strong>#{{ $appointment->id }}</strong></p>
    </div>

    <table class="table">
        <tbody>
            <tr>
                <th>PACIENTE</th>
                <td>{{ $appointment->patient->user->name }}</td>
            </tr>
            <tr>
                <th>TELÉFONO</th>
                <td>{{ $appointment->patient->phone_number ?? 'No registrado' }}</td>
            </tr>
            <tr>
                <th>DOCTOR</th>
                <td>{{ $appointment->doctor->user->name ?? 'No especificado' }}</td>
            </tr>
            <tr>
                <th>ESPECIALIDAD</th>
                <td>{{ $appointment->doctor->speciality->name ?? 'Medicina General' }}</td>
            </tr>
            <tr>
                <th>FECHA</th>
                <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>HORA</th>
                <td>{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}</td>
            </tr>
            <tr>
                <th>MOTIVO</th>
                <td>{{ $appointment->reason ?? 'No especificado' }}</td>
            </tr>
        </tbody>
    </table>

  
    <div class="footer">
        Este es un ticket de consulta médica generado automáticamente.<br>
        &copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
    </div>
</body>
</html>