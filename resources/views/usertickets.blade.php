<x-app-layout>

    @role('client')
        @section('title', 'Mis Billetes')
    @section('title-page', 'Mis Billetes')
@endrole

@role('admin')
    @section('title', 'Todos los billetes')
    @section('title-page', 'Billetes de ' . $user->name)
@endrole

@section('content')

    <div class="p-5 h-full w-full">
        <div class="flex flex-col md:flex-row justify-between items-center w-full mb-5 p-3 gap-3">
            <!-- Contenedor de los botones de filtro y añadir usuario -->
            <div class="flex justify-start items-center gap-3 w-full md:w-[50%]">

                <!-- Botón para abrir el modal de filtro -->
                <button class="flex items-center justify-center bg-[#22B3B2] w-10 h-10 rounded cursor-pointer"
                    id="filter-button">
                    <img src="{{ asset('icons/filter.png') }}" class="w-5 h-5">
                </button>

                <!-- Contenedor del buscador -->
                <div id="custom-search-container"></div>
            </div>

        </div>

        <!-- Tabla mis tickets -->
        <div class=" overflow-x-auto w-full p-3">
            <table class="table table-bordered justify-center items-center" id="UserTicketsTable">
                <thead class="bg-[#22B3B2] text-white uppercase">
                    <tr>

                        <th>Vuelo</th>
                        <th>Reserva</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Fecha de compra</th>
                        <th>Nº asiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!--Agregamos los contenedores para la paginación y mostrar registros -->
        <div id="custom-page-option" class="flex justify-end items-center w-full h-10 gap-5 my-8">
            <div id="lengthpage-option"></div>
            <div id="paginate-option"></div>
        </div>
    </div>


    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#UserTicketsTable').DataTable({
                    processing: true,
                    serverSide: true,

                    ajax: {
                        url: '{{ route('datatables.userTickets') }}',
                        data: function(d) {
                            // Si el usuario es un admin, pasa el user_id en la solicitud
                            @role('admin')
                                d.user_id =
                                '{{ request()->route('userId') }}'; // Pasar el userId en la solicitud
                            @endrole
                        }
                    },
                    columns: [{
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
                            data: 'purchase_date',
                            name: 'purchase_date',
                            orderable: false
                        },
                        {
                            data: 'seat_code',
                            name: 'seat_code',
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
                        paginate: {
                            previous: "<", // Reemplaza "Anterior" con "<"
                            next: ">" // Reemplaza "Siguiente" con ">"
                        },



                    },
                    lengthChange: true, // Desactiva la paginación
                    pageLength: 10,
                    info: false, // Desactiva la visualización de los registros
                    lengthMenu: [10, 20, 30],
                    initComplete: function() {
                        // Mover el buscador predeterminado al contenedor
                        $('#UserTicketsTable_filter').appendTo('#custom-search-container');

                        //Mover mostrar registros al contenedor
                        $('#UserTicketsTable_length').appendTo('#lengthpage-option');

                        //Mover paginacion al contenedor
                        $('#UserTicketsTable_paginate').appendTo('#paginate-option');

                        // Eliminar el texto predeterminado
                        $('#UserTicketsTable_filter label').contents().filter(function() {
                            return this.nodeType === 3; // Solo los nodos de texto
                        }).remove();

                        $('#UserTicketsTable_length label').contents().filter(function() {
                            return this.nodeType === 3; // Solo los nodos de texto
                        }).remove();

                        // Cambiar el placeholder
                        $('#UserTicketsTable_filter input').attr('placeholder', 'Buscar:');
                    }
                });
            });
        </script>
    @endpush
@endsection
</x-app-layout>
