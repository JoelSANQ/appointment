<x-admin-layout
    title="Nueva Cita | Medify"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Citas', 'href' => route('admin.appointments.index')],
        ['name' => 'Nuevo'],
    ]"
>

    <div class="max-w-7xl mx-auto">
        <form id="appointment_form" action="{{ route('admin.appointments.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                {{-- Columna Izquierda: Búsqueda y Resultados --}}
                <div class="lg:col-span-8 space-y-6">
                    
                    {{-- Card de Búsqueda --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Buscar disponibilidad</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha</label>
                                <input type="date" name="date" id="search_date" required 
                                       value="{{ date('Y-m-d') }}"
                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Especialidad (opcional)</label>
                                <select id="speciality_select"
                                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all appearance-none cursor-pointer">
                                    <option value="">Selecciona una espec...</option>
                                    @foreach ($specialities as $speciality)
                                        <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <button type="button" id="btn_search_doctors"
                                        class="w-full px-6 py-2.5 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all active:scale-95">
                                    Buscar disponibilidad
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Contenedor de Resultados (Doctor Cards) --}}
                    <div id="doctors_container" class="space-y-4">
                        {{-- Se llenará dinámicamente --}}
                        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-12 text-center">
                            <i class="fa-solid fa-calendar-alt text-blue-300 text-4xl mb-4"></i>
                            <p class="text-blue-600 font-medium">Ingresa una fecha y busca doctores disponibles.</p>
                        </div>
                    </div>
                </div>

                {{-- Columna Derecha: Resumen y Confirmación --}}
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 sticky top-24 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="text-lg font-bold text-gray-800">Resumen de la cita</h3>
                        </div>

                        <div class="p-6 space-y-6">
                            {{-- Datos de la Cita (Lectura) --}}
                            <div class="space-y-4">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500">Doctor:</span>
                                    <span id="summary_doctor" class="font-bold text-gray-800">No seleccionado</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500">Fecha:</span>
                                    <span id="summary_date" class="font-bold text-gray-800">--</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500">Horario:</span>
                                    <span id="summary_time" class="font-bold text-gray-800">--</span>
                                </div>
                            </div>

                            <hr class="border-gray-100">

                            {{-- Formulario Real --}}
                            <div class="space-y-4">
                                <div>
                                    <label for="patient_id" class="block text-sm font-semibold text-gray-700 mb-2">Paciente</label>
                                    <select name="patient_id" required
                                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none">
                                        <option value="">Selecciona un paciente...</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="reason" class="block text-sm font-semibold text-gray-700 mb-2">Motivo de la cita</label>
                                    <textarea name="reason" rows="3" required
                                              placeholder="Describe brevemente el motivo de la consulta..."
                                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all"></textarea>
                                </div>

                                {{-- Inputs ocultos para enviar los datos seleccionados --}}
                                <input type="hidden" name="doctor_id" id="input_doctor_id">
                                <input type="hidden" name="time" id="input_time">
                                <input type="hidden" name="date" id="input_date">

                                <button type="submit" id="btn_confirm_appointment" disabled
                                        class="w-full py-4 bg-blue-600 text-white rounded-2xl font-bold shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                                    Confirmar cita
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    @push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnSearch = document.getElementById('btn_search_doctors');
            const doctorsContainer = document.getElementById('doctors_container');
            const specialitySelect = document.getElementById('speciality_select');
            const searchDate = document.getElementById('search_date');

            // Summary elements
            const summaryDoctor = document.getElementById('summary_doctor');
            const summaryDate = document.getElementById('summary_date');
            const summaryTime = document.getElementById('summary_time');
            const inputDoctorId = document.getElementById('input_doctor_id');
            const inputTime = document.getElementById('input_time');
            const inputDate = document.getElementById('input_date');
            const btnConfirm = document.getElementById('btn_confirm_appointment');

            btnSearch.addEventListener('click', function() {
                const date = searchDate.value;
                const specialityId = specialitySelect.value;

                if (!date) {
                    Swal.fire('Atención', 'Selecciona una fecha.', 'warning');
                    return;
                }

                this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
                this.disabled = true;

                fetch(`{{ route('admin.appointments.available-doctors') }}?date=${date}&speciality_id=${specialityId}`)
                    .then(response => response.json())
                    .then(doctors => {
                        doctorsContainer.innerHTML = '';
                        
                        if (doctors.length === 0) {
                            doctorsContainer.innerHTML = `
                                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-12 text-center">
                                    <p class="text-gray-500 font-medium">No se encontraron doctores disponibles para esta fecha.</p>
                                </div>
                            `;
                        } else {
                            doctors.forEach(doctor => {
                                // Obtener slots ocupados de sus citas
                                const occupiedSlots = (doctor.appointments || []).map(a => a.time.substring(0, 5));
                                // Obtener slots de trabajo para el día
                                const availableSlots = (doctor.work_days[0]?.slots || [])
                                    .filter(slot => !occupiedSlots.includes(slot));

                                const card = document.createElement('div');
                                card.className = 'bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row gap-6 hover:border-blue-200 transition-all';
                                
                                let slotsHtml = availableSlots.length > 0 
                                    ? availableSlots.map(slot => `
                                        <button type="button" 
                                                onclick="selectSlot('${doctor.id}', '${doctor.user.name}', '${date}', '${slot}')"
                                                class="slot-btn px-4 py-2 bg-blue-50 text-blue-700 rounded-xl text-sm font-bold hover:bg-blue-600 hover:text-white transition-all">
                                            ${slot}
                                        </button>
                                    `).join('')
                                    : '<p class="text-xs text-red-500 italic">Sin horarios disponibles para hoy.</p>';

                                card.innerHTML = `
                                    <div class="flex-shrink-0">
                                        <div class="w-16 h-16 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl font-bold">
                                            ${doctor.user.name.split(' ').map(n => n[0]).take(2).join('').toUpperCase()}
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-bold text-gray-800">${doctor.user.name}</h4>
                                        <p class="text-sm text-blue-500 font-medium mb-4">${doctor.speciality ? doctor.speciality.name : 'Medicina General'}</p>
                                        
                                        <div class="space-y-2">
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Horarios disponibles:</p>
                                            <div class="flex flex-wrap gap-2">
                                                ${slotsHtml}
                                            </div>
                                        </div>
                                    </div>
                                `;
                                doctorsContainer.appendChild(card);
                            });
                        }

                        this.innerHTML = 'Buscar disponibilidad';
                        this.disabled = false;
                    })
                    .catch(err => {
                        console.error(err);
                        this.innerHTML = 'Buscar disponibilidad';
                        this.disabled = false;
                    });
            });

            // Función global para seleccionar slot
            window.selectSlot = function(doctorId, doctorName, date, time) {
                // UI updates
                summaryDoctor.innerText = doctorName;
                summaryDate.innerText = date;
                summaryTime.innerText = time;
                
                // Input updates
                inputDoctorId.value = doctorId;
                inputDate.value = date;
                inputTime.value = time;
                
                btnConfirm.disabled = false;

                // Visual feedback on buttons
                document.querySelectorAll('.slot-btn').forEach(btn => {
                    btn.classList.remove('bg-blue-600', 'text-white');
                    btn.classList.add('bg-blue-50', 'text-blue-700');
                    if (btn.innerText.trim() === time) {
                        btn.classList.remove('bg-blue-50', 'text-blue-700');
                        btn.classList.add('bg-blue-600', 'text-white');
                    }
                });

                Swal.fire({
                    icon: 'success',
                    title: 'Horario seleccionado',
                    text: `${doctorName} - ${time}`,
                    timer: 1500,
                    showConfirmButton: false
                });
            };

            Array.prototype.take = function(n) { return this.slice(0, n); };

            const form = document.getElementById('appointment_form');
            form.addEventListener('submit', function() {
                btnConfirm.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Procesando...';
                btnConfirm.disabled = true;
            });
        });
    </script>
    @endpush

</x-admin-layout>
