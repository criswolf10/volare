<x-app-layout>
    @section('title', 'Vuelos')
    @section('title-page', 'Listado de vuelos')

    @section('content')
        <div class=" p-5 h-full w-full">
            <div class="flex justify-center items-center w-full mb-6 p-3">

                <!-- Contenedor de los botones de filtro y añadir usuario -->
                <div class="flex justify-start items-center w-[50%] gap-5">

                    <!-- Botón para abrir el modal de filtro -->
                    <button class="flex items-center justify-center bg-[#22B3B2] w-10 h-10 rounded cursor-pointer"
                        id="filter-button">
                        <img src="{{ asset('icons/filter.png') }}" class="w-5 h-5">
                    </button>

                    <!-- Contenedor del buscador -->
                    <div id="custom-search-container"></div>
                </div>

                <!-- Botón para añadir un nuevo usuario -->
                <div class="flex justify-end items-center w-[50%]">
                    <div>
                        <x-tertiary-button>
                            <a href="{{ route('create-flights') }}">+ Añadir vuelo</a>
                        </x-tertiary-button>
                    </div>
                </div>
            </div>


            <div class=" overflow-x-auto w-full p-3">
                <table class="table table-bordered justify-center items-center" id="flights-table">
                    <thead class="bg-[#22B3B2] text-white uppercase ">
                        <tr>
                            <th></th>
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
            <!--Agregamos los contenedores para la paginación y mostrar registros -->
            <div id="custom-page-option" class="flex justify-end items-center w-full h-10 gap-5 my-8">
                <div id="lengthpage-option"></div>
                <div id="paginate-option"></div>
            </div>
        </div>

        <x-filter-modal title="Filtrar Vuelos" :fields="[]" />

        @push('scripts')
            <script>
                $(document).ready(function() {
                    var table = $('#flights-table').DataTable({
                        processing: true,
                        serverSide: true,
                        orderable: false,
                        ajax: {
                            url: '{{ route('flights.flightDatatable') }}',
                            data: function(d) {
                                // Adjuntar filtros
                                const formData = $('#filter-form').serializeArray();
                                formData.forEach(field => {
                                    d[field.name] = field.value;
                                });
                            },
                        },
                        columns: [{

                                data: 'image',
                                name: 'image',
                                orderable: false
                            },
                            {
                                data: 'code',
                                name: 'code',
                                orderable: false
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
                                data: 'seat_classes',
                                name: 'seat_classes',
                                orderable: false
                            },
                            {
                                data: 'departure_date',
                                name: 'departure_date',
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
                            $('#flights-table_filter').appendTo('#custom-search-container');

                            //Mover mostrar registros al contenedor
                            $('#flights-table_length').appendTo('#lengthpage-option');

                            //Mover paginacion al contenedor
                            $('#flights-table_paginate').appendTo('#paginate-option');

                            // Eliminar el texto predeterminado
                            $('#flights-table_filter label').contents().filter(function() {
                                return this.nodeType === 3; // Solo los nodos de texto
                            }).remove();

                            $('#flights-table_length label').contents().filter(function() {
                                return this.nodeType === 3; // Solo los nodos de texto
                            }).remove();

                            // Cambiar el placeholder
                            $('#flights-table_filter input').attr('placeholder', 'Buscar:');
                        }
                    });

                    // Mostrar el modal de filtro
                    $('#filter-button').click(function(e) {
                        e.stopPropagation();
                        $('#filter-modal').toggleClass('hidden'); // Mostrar u ocultar el modal
                        if (!$('#filter-modal').hasClass('hidden')) {
                            var offset = $(this).offset();
                            $('#filter-modal').css({
                                top: offset.top + $(this).outerHeight(),
                                left: offset.left
                            });
                        }
                    });

                    // Cerrar el modal
                    $('#cancel-filter').click(function() {
                        $('#filter-modal').addClass('hidden');
                    });

                    // Enviar el formulario de filtro
                    $('#filter-form').submit(function(e) {
                        e.preventDefault();
                        table.draw();
                        $('#filter-modal').addClass('hidden');
                    });

                    // Cerrar el modal al hacer clic en el boton o fuera de él
                    $(document).click(function(event) {
                        if (!$(event.target).closest('#filter-button').length && !$(event.target).closest(
                                '#filter-modal').length) {
                            $('#filter-modal').addClass('hidden');
                        }
                    });
                });
            </script>
        @endpush

    @endsection
</x-app-layout>
