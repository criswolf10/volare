<x-app-layout>
    @section('title', 'Confirmación de Cancelación de Billete')

    @section('content')
        <div class="p-6 space-y-6">
            <h2 class="text-2xl xl:text-3xl font-bold text-gray-900 mb-6">Confirmación de Cancelación</h2>

            @if (session('error'))
                <div class="bg-red-200 text-red-700 p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-200 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Detalles del billete -->
            <div class="bg-[#E4F2F2] p-6 rounded-lg shadow-md mb-6">
                <h3 class="text-xl font-semibold mb-4">Detalles del Billete:</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div><strong>Vuelo:</strong> {{ $ticket->flight->code }} - {{ $ticket->flight->origin }} a {{ $ticket->flight->destination }}</div>
                    <div><strong>Nombre del pasajero:</strong> {{ $ticket->passenger->name }} {{ $ticket->passenger->lastname }}</div>
                    <div><strong>Asiento:</strong> {{ $ticket->seat->seat_code }} ({{ ucfirst(str_replace('_', ' ', $ticket->seat->class)) }})</div>
                    <div><strong>Fecha y hora del vuelo:</strong> {{ $ticket->flight->departure_date }} a las {{ $ticket->flight->departure_time }}</div>
                </div>
            </div>

            <!-- Información sobre cancelación y reembolso -->
            <div class="bg-[#FFF9E6] p-6 rounded-lg shadow-md mb-6">
                <h3 class="text-lg font-semibold mb-4">Condiciones de Cancelación:</h3>
                <p>
                    @php
                        $timeDifference = \Carbon\Carbon::parse($ticket->flight->departure_date . ' ' . $ticket->flight->departure_time)->diffInDays(now());
                    @endphp
                    @if ($timeDifference <= 7)
                        El billete será cancelado, pero no habrá reembolso, pero le ofrecemos la posibilidad de cambiarlo por otro, ya que el vuelo es en menos de 7 días.
                    @else
                        El billete será cancelado y se procederá al reembolso, ya que el vuelo es dentro de más de 7 días.
                    @endif
                </p>
            </div>

            <!-- Formulario de cancelación -->
            <form method="POST" action="{{ route('tickets.delete', $ticket->id) }}">
                @csrf
                @method('DELETE')

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Introduce tu contraseña para confirmar:</label>
                    <input type="password" id="password" name="password"  class="w-full p-3 border rounded-lg" placeholder="contraseña">
                    @error('password')
                        <div class="text-red-600 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-6 flex justify-center gap-4">
                    <x-danger-button type="submit" class="px-6 py-3 text-lg xl:w-[30%]">
                        Cancelar Billete
                    </x-danger-button>
                </div>
            </form>
        </div>
    @endsection
</x-app-layout>
