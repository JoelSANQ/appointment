<h2>Agenda de Citas para Hoy ({{ $date }})</h2>
<p>Estimado(a) Dr(a). {{ $doctor->user->name }},</p>
<p>Esta es su lista de pacientes agendados para el día de hoy:</p>

<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Hora</th>
            <th>Paciente</th>
            <th>Motivo</th>
        </tr>
    </thead>
    <tbody>
        @forelse($appointments as $appointment)
            <tr>
                <td>{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                <td>{{ $appointment->patient->name }}</td>
                <td>{{ $appointment->reason ?? 'N/A' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" style="text-align: center;">No tiene citas agendadas para hoy.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<p>Que tenga un excelente día laboral.</p>
