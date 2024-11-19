<x-app-layout>
    @section('title', 'Vuelos')
    @section('title-page', 'Listado de vuelos')

    @section('content')
        <div class=" p-5 overflow-x-auto h-full">

            <table class="table table-bordered" id="flights-table">
                <thead class="bg-[#909494] text-white uppercase">
                    <tr>
                        <th>Vuelo</th>
                        <th>Avión</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Duración</th>
                        <th>Precio</th>
                        <th>Asientos</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>


        @push('scripts')
            <script>
                $(document).ready(function() {
                    $('#flights-table').DataTable({
                        processing: true,
                        serverSide: true,
                        orderable: false,
                        ajax: '{{ route('flights.getFlights') }}',
                        columns: [{
                                data: 'code',
                                name: 'code',
                            
                            },
                            {
                                data: 'aircraft',
                                name: 'aircraft',
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
                                data: 'duration',
                                name: 'duration',
                                orderable: false
                            },
                            {
                                data: 'price',
                                name: 'price',
                                orderable: false
                            },
                            {
                                data: 'seats',
                                name: 'seats',
                                orderable: false
                            },
                            {
                                data: 'date',
                                name: 'date',
                                orderable: false
                            },
                            {
                                data: 'status',
                                name: 'status',
                                orderable: false
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                        },
                        pageLength: 15,
                        lengthMenu: [10, 30, 45],
                    });
                });
            </script>
        @endpush
    @endsection
</x-app-layout>
