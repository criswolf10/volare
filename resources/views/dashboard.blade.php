<x-app-layout>
    @section('title', 'Dashboard')
    @section('title-page', 'Dashboard')
    @section('content')

        <div class="flex flex-col w-full p-5 xl:flex-row gap-5">
            <!-- Sección de "Últimos billetes vendidos" y "Últimos vuelos con menos plazas libres" para Admin -->
            @if(auth()->user()->hasRole('admin'))
            <section class="flex flex-col bg-[#E4F2F2] h-full w-full shadow-md rounded-lg p-5 xl:w-[60%]">
                <h3 class="text-lg font-bold">Últimos Billetes Vendidos</h3>
                <ul>
                    @foreach ($lastTickets as $ticket)
                        <li>{{ $ticket->flight->code }} - {{ $ticket->user->name }} - {{ $ticket->created_at }}</li>
                    @endforeach
                </ul>
            </section>

            <!-- Sección de "Últimos vuelos con menos plazas libres" para Admin -->
            <section class="flex flex-col bg-[#E4F2F2] h-full w-full shadow-md rounded-lg p-5 xl:w-[40%]">
                <h3 class="text-lg font-bold">Últimos Vuelos con Menos Plazas Libres</h3>
                <ul>
                    @foreach ($flightsWithSeats as $flight)
                        <li>{{ $flight->code }} - {{ $flight->available_seats }} plazas libres</li>
                    @endforeach
                </ul>
            </section>
            @endif
        </div>

        <div class="flex flex-col w-full p-5 xl:flex-row gap-5">
            <!-- Sección de "Últimos billetes comprados" y "Últimos vuelos para Cliente" -->
            @if(!auth()->user()->hasRole('admin'))
            <section class="flex flex-col bg-[#E4F2F2] h-full w-full shadow-md rounded-lg p-5 xl:w-[60%]">
                <h3 class="text-lg font-bold">Mis Últimos Billetes Comprados</h3>
                <ul>
                    @foreach ($lastTickets as $ticket)
                        <li>{{ $ticket->flight->code }} - {{ $ticket->created_at }}</li>
                    @endforeach
                </ul>
            </section>

            <!-- Sección de "Últimos vuelos más recientes" para Cliente -->
            <section class="flex flex-col bg-[#E4F2F2] h-full w-full shadow-md rounded-lg p-5 xl:w-[40%]">
                <h3 class="text-lg font-bold">Últimos Vuelos Más Recientes</h3>
                <ul>
                    @foreach ($latestFlights as $flight)
                        <li>{{ $flight->code }} - {{ $flight->departure_date }}</li>
                    @endforeach
                </ul>
            </section>
            @endif
        </div>

    @endsection
</x-app-layout>
