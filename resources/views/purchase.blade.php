<x-app-layout>
    @section('title', 'Compra de Billete')

    @section('content')
        @if ($errors->any())
            <div class="bg-red-200 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="p-6 space-y-6">
            <h2 class="text-2xl xl:text-3xl font-bold text-gray-900">Compra de Billete para el vuelo {{ $flight->code }}</h2>

            <!-- Información del vuelo -->
            <div class="bg-[#E4F2F2] p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4">Detalles del vuelo</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div><strong>Origen:</strong> {{ $flight->origin }}</div>
                    <div><strong>Destino:</strong> {{ $flight->destination }}</div>
                    <div><strong>Fecha de salida:</strong> {{ $flight->departure_date }}</div>
                    <div><strong>Hora de salida:</strong> {{ $flight->departure_time }} </div>
                    <div><strong>Duración:</strong> {{ $flight->duration }}</div>
                </div>
            </div>

            <!-- Formulario de compra -->
            <form action="{{ route('tickets.processPurchase', $flight->id) }}" method="POST">
                @csrf


                <!-- Sección de información del pasajero -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-semibold mb-2">Nombre:</label>
                        <input type="text" id="name" name="name" class="w-full p-3 border rounded-lg" placeholder="Nombre del pasajero" required>
                    </div>
                    <div class="mb-4">
                        <label for="lastname" class="block text-gray-700 font-semibold mb-2">Apellidos:</label>
                        <input type="text" id="lastname" name="lastname" class="w-full p-3 border rounded-lg" placeholder="Apellidos del pasajero" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">Correo electrónico:</label>
                        <input type="email" id="email" name="email" class="w-full p-3 border rounded-lg" placeholder="Correo electrónico" required>
                    </div>
                    <div class="mb-4">
                        <label for="dni" class="block text-gray-700 font-semibold mb-2">Documento de Identidad:</label>
                        <input type="text" id="dni" name="dni" class="w-full p-3 border rounded-lg" placeholder="Documento de identidad" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 font-semibold mb-2">Teléfono:</label>
                        <input type="text" id="phone" name="phone" class="w-full p-3 border rounded-lg" placeholder="Teléfono del pasajero" required>
                    </div>

                    <!-- Selector de clase -->
                    <div class="mb-4">
                        <label for="class" class="block text-gray-700 font-semibold mb-2">Clase:</label>
                        <select id="class" name="class" onchange="updateSeats()" class="w-full p-3 border rounded-lg" required>
                            <option value="">Selecciona una clase</option>
                            @foreach ($availableSeats as $class => $seats)
                                <option value="{{ $class }}">{{ ucfirst(str_replace('_', ' ', $class)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Selector de asiento -->
                <div class="mb-6">
                    <label for="seat_code" class="block text-gray-700 font-semibold mb-2">Número de Asiento:</label>
                    <select id="seat_code" name="seat_code" class="w-full p-3 border rounded-lg" required>
                        <option value="">Selecciona un asiento</option>
                        <!-- Opciones dinámicas con JavaScript -->
                    </select>
                </div>

                <!-- Precio del billete -->
                <div class="mb-6">
                    <p id="seat-price" class="text-lg font-bold">Precio: --</p>
                </div>

                <button type="submit" class="bg-[#22B3B2] text-white px-6 py-3 rounded-lg hover:bg-opacity-75 transition duration-300">
                    Comprar
                </button>
            </form>
        </div>

        <!-- JavaScript -->
        <script>
            const availableSeats = @json($availableSeats);

            function updateSeats() {
                const selectedClass = document.getElementById('class').value;
                const seatSelect = document.getElementById('seat_code');
                const priceField = document.getElementById('seat-price');

                // Reiniciar campos
                seatSelect.innerHTML = '<option value="">Selecciona un asiento</option>';
                priceField.textContent = 'Precio: --';

                if (availableSeats[selectedClass]) {
                    availableSeats[selectedClass].forEach(seat => {
                        const option = document.createElement('option');
                        option.value = seat.seat_code;
                        option.textContent = `${seat.seat_code} - ${seat.price}€`;
                        option.dataset.price = seat.price;
                        seatSelect.appendChild(option);
                    });
                }
            }

            document.getElementById('seat_code').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                document.getElementById('seat-price').textContent = 'Precio: ' + (selectedOption.dataset.price || '--') + '€';
            });
        </script>
    @endsection
</x-app-layout>
