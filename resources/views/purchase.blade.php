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

        <div class="p-6">
            <h2 class="text-2xl font-bold mb-4">Compra de Billete para el vuelo {{ $flight->code }}</h2>

            <!-- Información del vuelo -->
            <div class="mb-4">
                <p><strong>Origen:</strong> {{ $flight->origin }}</p>
                <p><strong>Destino:</strong> {{ $flight->destination }}</p>
                <p><strong>Fecha de salida:</strong> {{ $flight->departure_date }}</p>
                <p><strong>Hora de salida:</strong> {{ $flight->departure_time }} </p>
                <p><strong>Duración:</strong> {{ $flight->duration }}</p>
            </div>

            <!-- Formulario -->
            <form action="{{ route('tickets.processPurchase', $flight->id) }}" method="POST">
                @csrf
                @method('patch')
                <!-- Informacion del pasajero (nombre, apellidos, ) -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Nombre:</label>
                    <input type="text" id="name" name="name" required class="w-full p-2 border rounded"
                        placeholder="Nombre del pasajero">
                </div>
                <div class="mb-4">
                    <label for="lastname" class="block text-gray-700 font-bold mb-2">Apellidos:</label>
                    <input type="text" id="lastname" name="lastname" required class="w-full p-2 border rounded"
                        placeholder="Apellidos del pasajero">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold mb-2">Correo electrónico:</label>
                    <input type="email" id="email" name="email" class="w-full p-2 border rounded"
                        placeholder="Correo electrónico del pasajero">
                </div>

                <div class="mb-4">
                    <label for="dni" class="block text-gray-700 font-bold mb-2">Documento de Identidad:</label>
                    <input type="text" id="dni" name="dni" class="w-full p-2 border rounded"
                        placeholder="Documento de identidad del pasajero">
                </div>

                <!-- campo telefono -->
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-bold mb-2">Teléfono:</label>
                    <input type="text" id="phone" name="phone" class="w-full p-2 border rounded"
                        placeholder="Teléfono del pasajero">

                <!-- Selector de clase -->
                <div class="mb-4">
                    <label for="class" class="block text-gray-700 font-bold mb-2">Clase:</label>
                    <select id="class" name="class" required onchange="updateSeats()"
                        class="w-full p-2 border rounded">
                        <option value="">Selecciona una clase</option>
                        @foreach ($availableSeats as $class => $seats)
                            <option value="{{ $class }}">{{ ucfirst(str_replace('_', ' ', $class)) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Selector de asiento -->
                <div class="mb-4">
                    <label for="seat_code" class="block text-gray-700 font-bold mb-2">Número de Asiento:</label>
                    <select id="seat_code" name="seat_code" required class="w-full p-2 border rounded">
                        <option value="">Selecciona un asiento</option>
                        <!-- Opciones dinámicas con JavaScript -->
                    </select>
                </div>

                <!-- Precio del billete -->
                <div class="mb-4">
                    <p id="seat-price" class="text-lg font-bold">Precio: --</p>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
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
                document.getElementById('seat-price').textContent = 'Precio: ' + (selectedOption.dataset.price ||
                    '--') + '€';
            });
        </script>
    @endsection
</x-app-layout>
