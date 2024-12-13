<x-app-layout>

    @section('content')
    <section>
        <div class="flex flex-col justify-start bg-white shadow-lg rounded-lg p-5 gap-2">
            <h2 class="text-lg xl:text-3xl font-semibold text-gray-900">
                {{ __('Compra tu billete de vuelo') }}
            </h2>

            <form method="POST" action="{{ route('tickets.purchase') }}" class="mt-4">
                @csrf

                <!-- Datos del pasajero -->
                <div class="mb-4">
                    <x-input-label for="passenger_name" value="{{ __('Nombre del pasajero') }}" class="block text-sm font-medium text-gray-700" />
                    <x-text-input type="text" name="passenger_name" id="passenger_name" class="mt-1 block w-full" required />
                </div>

                <div class="mb-4">
                    <x-input-label for="passenger_lastname" value="{{ __('Apellidos del pasajero') }}" class="block text-sm font-medium text-gray-700" />
                    <x-text-input type="text" name="passenger_lastname" id="passenger_lastname" class="mt-1 block w-full" required />
                </div>

                <div class="mb-4">
                    <x-input-label for="email" value="{{ __('Correo electrónico') }}" class="block text-sm font-medium text-gray-700" />
                    <x-text-input type="email" name="email" id="email" class="mt-1 block w-full" />
                </div>

                <div class="mb-4">
                    <x-input-label for="phone" value="{{ __('Teléfono') }}" class="block text-sm font-medium text-gray-700" />
                    <x-text-input type="text" name="phone" id="phone" class="mt-1 block w-full" />
                </div>

                <!-- Datos del vuelo -->
                <div class="mb-4">
                    <x-input-label for="flight_code" value="{{ __('Código de vuelo') }}" class="block text-sm font-medium text-gray-700" />
                    <x-text-input type="text" name="flight_code" id="flight_code" class="mt-1 block w-full" value="{{ old('flight_code', $flight->code) }}" required readonly />
                </div>

                <div class="mb-4">
                    <x-input-label for="origin" value="{{ __('Origen') }}" class="block text-sm font-medium text-gray-700" />
                    <x-text-input type="text" name="origin" id="origin" class="mt-1 block w-full" value="{{ old('origin', $flight->origin) }}" required readonly />
                </div>

                <div class="mb-4">
                    <x-input-label for="destination" value="{{ __('Destino') }}" class="block text-sm font-medium text-gray-700" />
                    <x-text-input type="text" name="destination" id="destination" class="mt-1 block w-full" value="{{ old('destination', $flight->destination) }}" required readonly />
                </div>

                <div class="mb-4">
                    <x-input-label for="departure_date" value="{{ __('Fecha de salida') }}" class="block text-sm font-medium text-gray-700" />
                    <x-text-input type="text" name="departure_date" id="departure_date" class="mt-1 block w-full" value="{{ old('departure_date', \Carbon\Carbon::parse($flight->departure_date)->format('d/m/Y')) }}" required readonly />
                </div>

                <div class="mb-4">
                    <x-input-label for="departure_time" value="{{ __('Hora de salida') }}" class="block text-sm font-medium text-gray-700" />
                    <x-text-input type="text" name="departure_time" id="departure_time" class="mt-1 block w-full" value="{{ old('departure_time', \Carbon\Carbon::parse($flight->departure_time)->format('H:i')) }}" required readonly />
                </div>

                <div class="mb-4">
                    <x-input-label for="arrival_time" value="{{ __('Hora de llegada') }}" class="block text-sm font-medium text-gray-700" />
                    <x-text-input type="text" name="arrival_time" id="arrival_time" class="mt-1 block w-full" value="{{ old('arrival_time', \Carbon\Carbon::parse($flight->arrival_time)->format('H:i')) }}" required readonly />
                </div>

                <!-- Selección de clase de asiento -->
                <div class="mb-4">
                    <x-input-label for="seat_class" value="{{ __('Clase de asiento') }}" class="block text-sm font-medium text-gray-700" />
                    <select name="seat_class" id="seat_class" class="mt-1 block w-full" required>
                        <option value="1ª clase">1ª clase</option>
                        <option value="2ª clase">2ª clase</option>
                        <option value="turista">Turista</option>
                    </select>
                </div>

                <!-- Selección de número de asiento -->
                <div class="mb-4">
                    <x-input-label for="seat_number" value="{{ __('Número de asiento') }}" class="block text-sm font-medium text-gray-700" />
                    <x-text-input type="text" name="seat_number" id="seat_number" class="mt-1 block w-full" required />
                </div>

                <!-- Precio -->
                <div class="mb-4">
                    <x-input-label for="price" value="{{ __('Precio') }}" class="block text-sm font-medium text-gray-700" />
                    <x-text-input type="text" name="price" id="price" class="mt-1 block w-full" value="{{ old('price', $flight->price) }}" required readonly />
                </div>

                <div class="flex items-center gap-4 mb-3">
                    <x-tertiary-button>
                        {{ __('Comprar Billete') }}
                    </x-tertiary-button>
                    <x-danger-button>
                        <a href="{{ route('flights') }}">{{ __('Cancelar') }}</a>
                    </x-danger-button>
                </div>
            </form>
        </div>
    </section>
    @endsection

    </x-app-layout>
