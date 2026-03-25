<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante de Cita Médica</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0056b3;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #0056b3;
            margin: 0;
        }
        .content {
            margin-bottom: 30px;
        }
        .content p {
            margin: 5px 0;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table th, .details-table td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .details-table th {
            background-color: #f8f9fa;
            width: 30%;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 50px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Comprobante de Cita</h1>
        <p>Sistema de Gestión de Citas Médicas</p>
    </div>

    <div class="content">
        <p>Estimado(a) <strong>{{ $appointment->patient->name }}</strong>,</p>
        <p>Adjunto encontrará el comprobante de su cita programada.</p>

        <table class="details-table">
            <tr>
                <th>Paciente:</th>
                <td>{{ $appointment->patient->name }}</td>
            </tr>
            <tr>
                <th>Doctor:</th>
                <td>{{ $appointment->doctor->user->name }}</td>
            </tr>
            <tr>
                <th>Especialidad:</th>
                <td>{{ $appointment->doctor->speciality->name }}</td>
            </tr>
            <tr>
                <th>Fecha:</th>
                <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Hora:</th>
                <td>{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
            </tr>
            <tr>
                <th>Motivo:</th>
                <td>{{ $appointment->reason ?? 'No especificado' }}</td>
            </tr>
            <tr>
                <th>Estado:</th>
                <td>{{ $appointment->status }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Este es un documento generado automáticamente. Si tiene alguna duda, por favor contáctenos.</p>
        <p>&copy; {{ date('Y') }} Centro Médico. Todos los derechos reservados.</p>
    </div>
</body>
</html>
