<h2>Reporte de Citas para Hoy ({{ $date }})</h2>
<p>Hola Administrador, esta es la lista de pacientes agendados para el día de hoy:</p>

<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Hora</th>
            <th>Paciente</th>
            <th>Doctor</th>
            <th>Motivo</th>
        </tr>
    </thead>
    <tbody>
        @forelse($appointments as $appointment)
            <tr>
                <td>{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                <td>{{ $appointment->patient->name }}</td>
                <td>{{ $appointment->doctor->user->name }}</td>
                <td>{{ $appointment->reason ?? 'N/A' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center;">No hay citas agendadas para hoy.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<p>Saludos,<br>Sistema de Citas Médicas</p>
