<x-app-layout>
    @section('title', 'Dashboard')
    @section('title-page', 'Dashboard')
    @section('content')

        <div class="flex flex-col w-full p-5 xl:flex-row gap-5">
            <!-- Sección de "Últimos billetes comprados" y "Últimos vuelos para Cliente" -->

            <section class="overflow-x-auto w-full bg-[#E4F2F2] p-5 shadow-md rounded-lg xl:w-[60%]">
                <h3 class="text-lg xl:text-3xl mb-6 font-bold">Últimas compras</h3>
                <table id="lastTicketsTable" class="">
                    <thead class="bg-[#22B3B2] font-bold text-white text-center uppercase">
                        <tr>
                            <th>Usuario</th>
                            <th>Vuelo</th>
                            <th>Reserva</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="font-bold">
                        <!-- La tabla será llenada dinámicamente por DataTables -->
                    </tbody>
                </table>
            </section>


            <!-- Sección de "Últimos vuelos más recientes" para Cliente -->
            @role('client')
                <section class="flex flex-col bg-[#E4F2F2] h-full w-full shadow-md rounded-lg p-5 xl:w-[35%] flex-grow">
                    <h3 class="text-lg xl:text-3xl mb-6 font-bold">Últimos vuelos</h3>
                    <ul>
                        @forelse ($latestFlights as $flight)
                            <li class="mb-4">
                                <div class="flex justify-around items-center bg-white p-2 shadow-md rounded-lg">
                                    <div class="flex flex-col justify-center items-start w-[50%]">
                                        <div class="text-lg  font-bold">
                                        Vuelo {{ $flight->code }}
                                        </div>
                                        <div class="flex text-sm  text-gray-600">
                                            {{ $flight->origin }} → {{ $flight->destination }}
                                        </div>
                                    </div>
                                    <div class="flex justify-end items-end pr-8 w-[50%] text-sm text-gray-600 mt-2">
                                        <a href="{{ route('tickets.purchase', ['flightId' => $flight->id]) }}"
                                            class="btn btn-sm btn-primary">
                                            <img src="{{ asset('icons/shop.png') }}" alt="buy" >
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="text-sm text-gray-600">No hay vuelos recientes.</li>
                        @endforelse
                    </ul>
                </section>
            @endrole

            @role('admin')
                <section class="flex flex-col bg-[#E4F2F2] h-full w-full shadow-md rounded-lg p-5 xl:w-[40%] flex-grow">
                    <h3 class="text-lg xl:text-3xl mb-6 font-bold">Vuelos con plazas vacantes</h3>
                    <ul>
                        @forelse ($flightsWithVacancies as $flight)
                        <li class="mb-4 ">
                            <div class="flex flex-col justify-center items-center h-[110px] bg-white p-3 shadow-md rounded-lg">
                                <!-- Información del vuelo -->
                                <div class="flex w-full justify-between items-center">
                                    <!-- Detalles del vuelo -->
                                    <div class="w-[70%]">
                                        <div class="text-lg xl:text-2xl font-bold">
                                            <a href="{{ route('edit.flights', ['id' => $flight->id]) }}" class="underline hover:opacity-75 transition duration-200">Vuelo {{ $flight->code }}</a>
                                        </div>
                                        <div class="text-sm xl:text-lg text-gray-600">
                                            {{ $flight->origin }} → {{ $flight->destination }}
                                        </div>
                                    </div>

                                    <!-- Porcentaje libre -->
                                    <div class="w-[30%] flex justify-end items-center mt-8">
                                        <div class="text-xl font-bold text-[#22B3B2]">
                                            {{ $flight->free_percentage }}%
                                        </div>
                                    </div>
                                </div>

                                <!-- Barra de progreso -->
                                <div class="w-full bg-[#E4F2F2] rounded-full h-5 mt-3">
                                    <!-- Barra de asientos libres -->
                                    <div class="bg-[#22B3B2] h-5 rounded-full" style="width: {{ $flight->free_percentage }}%;"></div>
                                </div>
                            </div>
                        </li>

                        @empty
                            <li class="text-sm text-gray-600">No hay vuelos con plazas vacantes.</li>
                        @endforelse
                    </ul>
                </section>
            @endrole

        </div>

        @push('scripts')
            <script>
                $(document).ready(function() {
                    $('#lastTicketsTable').DataTable({
                        processing: true,
                        serverSide: true,

                        ajax: '{{ route('tickets.LastTicketsUserDatatable') }}',
                        columns: [{
                                data: 'full_name',
                                name: 'full_name',
                                orderable: false
                            },
                            {
                                data: 'code',
                                name: 'code',
                                orderable: false
                            },
                            {
                                data: 'booking_code',
                                name: 'booking_code',
                                orderable: false
                            },
                            {
                                data: 'origin',
                                name: 'origin',
                                orderable: false
                            },
                            {
                                data: 'destination',
                                name: 'destination',
                                orderable: false
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            },
                        ],
                        language: {
                            url: '/lang/es.json'
                        },
                        lengthChange: false,
                        searching: false,
                        info: false,
                        paging: false,
                    });
                });
            </script>
        @endpush
    @endsection
</x-app-layout>
