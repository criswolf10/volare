<x-app-layout>
    @section('title', 'Confirmación de Cancelación de Billete')

    @section('content')
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-4">Confirmación de Cancelación</h2>

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
            <div class="mb-4">
                <h3 class="text-xl font-semibold">Detalles del Billete:</h3>
                <p><strong>Vuelo:</strong> {{ $ticket->flight->code }} - {{ $ticket->flight->origin }} a {{ $ticket->flight->destination }}</p>
                <p><strong>Nombre del pasajero:</strong> {{ $ticket->passenger->name }} {{ $ticket->passenger->lastname }}</p>
                <p><strong>Asiento:</strong> {{ $ticket->seat->seat_code }} ({{ ucfirst(str_replace('_', ' ', $ticket->seat->class)) }})</p>
                <p><strong>Fecha del vuelo:</strong> {{ $ticket->flight->departure_date }} a las {{ $ticket->flight->departure_time }}</p>
            </div>

            <!-- Información sobre cancelación y reembolso -->
            <div class="mb-4">
                <h3 class="text-lg font-semibold">Condiciones de Cancelación:</h3>
                <p>
                    @php
                        $timeDifference = \Carbon\Carbon::parse($ticket->flight->departure_date . ' ' . $ticket->flight->departure_time)->diffInDays(now());
                    @endphp
                    @if ($timeDifference <= 7)
                        El billete será cancelado, pero no hay reembolso ya que el vuelo es en menos de 7 días.
                    @else
                        El billete será cancelado y se procederá al reembolso, ya que el vuelo es dentro de más de 7 días.
                    @endif
                </p>
            </div>

            <!-- Formulario de cancelación -->
            <form method="POST" action="{{ route('tickets.delete', $ticket->id) }}">
                @csrf
                @method('DELETE')

                <div class="mt-6">
                    <label for="password" class="block text-gray-700 font-bold mb-2">Contraseña de confirmación:</label>
                    <input type="password" id="password" name="password" required class="w-full p-2 border rounded" placeholder="Introduce tu contraseña para confirmar la cancelación">
                    @error('password')
                        <div class="text-red-600 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-6 flex justify-center gap-3">
                    <x-danger-button type="submit">
                        Cancelar Billete
                    </x-danger-button>
                    <a href="{{ route('tickets') }}" class="btn btn-sm btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    @endsection
</x-app-layout>
