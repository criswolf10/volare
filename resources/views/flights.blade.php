<x-app-layout>
    @section('title', 'Vuelos')
    @role('admin')
        @section('title-page', 'Listado de vuelos')
    @endrole
    @section('title-page', 'Vuelos disponibles')

    @section('content')
        {{-- Modal de Éxito --}}
        @if (session('success'))
            <x-modal name="flight-delete-modal" show="true">
                <!-- Mensaje de éxito -->
                <div class="text-center py-8">
                    <h3 class="text-xl font-semibold text-green-600">Vuelo cancelado correctamente!</h3>
                    <p class="mt-2 text-gray-600">El vuelo ha sido cancelado y los usuarios han sido notificados por correo
                        electrónico.
                    </p>
                </div>

                <!-- Botón de acción -->
                <div class="flex justify-around mb-6">
                    <a href="{{ route('flights') }}" class="px-4 py-2 bg-[#22B3B2] hover:bg-opacity-75 text-white rounded-lg">
                        Aceptar
                    </a>
                </div>
            </x-modal>
        @endif

        {{-- Modal de Error: Vuelo en trayecto --}}
        @if (session('error'))
            <x-modal name="flight-delete-error" show="true">
                <div class="text-center py-8">
                    <h3 class="text-xl font-semibold text-red-600">No se puede cancelar este vuelo</h3>
                    <p class="mt-2 text-gray-600">{{ session('error') }}</p>
                </div>
                <div class="flex justify-around mb-6">
                    <a href="{{ route('flights') }}"
                        class="px-4 py-2 bg-[#f44336] hover:bg-opacity-75 text-white rounded-lg">Aceptar</a>
                </div>
            </x-modal>
        @endif

        <div class=" p-5 h-full w-full">
            <div
                class="{{ auth()->check() && auth()->user()->hasRole('admin') ? 'flex justify-center items-center w-full mb-6 p-3' : 'flex justify-start items-center w-full mb-6 p-3' }}">
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

                @role('admin')
                    <!-- Botón para añadir un nuevo usuario -->
                    <div class="flex justify-end items-center w-[50%]">
                        <div>
                            <x-tertiary-button>
                                <a href="{{ route('flights.create') }}">+ Añadir vuelo</a>
                            </x-tertiary-button>
                        </div>
                    </div>
                @endrole
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
                            <th>Tipos de asientos</th>
                            <th>Fecha</th>
                            @role('admin')
                                <th>Estado</th>
                            @endrole
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
        {{--
        <x-filter-modal title="Filtrar Vuelos" :fields="[
            ['label' => 'Origen', 'name' => 'origin', 'type' => 'select', 'options' => $origins],
            ['label' => 'Destino', 'name' => 'destination', 'type' => 'select', 'options' => $destinations],
            ['label' => 'Tipo de Asiento', 'name' => 'seats', 'type' => 'select', 'options' => $seatsTypes],
            ['label' => 'Precio', 'name' => 'price', 'type' => 'range', 'min' => 0, 'max' => 1000],
            ['label' => 'Fecha Desde', 'name' => 'departure_date_from', 'type' => 'date'],
            ['label' => 'Fecha Hasta', 'name' => 'departure_date_to', 'type' => 'date'],
        ]">
        </x-filter-modal> --}}


        <x-modal name="flight-deletion" :show="false" focusable>
            <div x-data="{
                flightId: null,
                open(id) {
                    this.flightId = id;
                    this.$dispatch('open-modal', 'flight-deletion');
                },
                close() {
                    this.$dispatch('close-modal', 'flight-deletion');
                },
                submitForm() {
                    const actionUrl = '/admin/edit-flights/' + this.flightId;
                    console.log('Enviando solicitud a: ', actionUrl); // Agregar este log
                    document.getElementById('delete-form').action = actionUrl;
                    document.getElementById('delete-form').submit();
                    this.close(); // Cerrar el modal después de enviar
                }

            }" x-on:flight-deletion.window="open($event.detail.flightId)">

                <form method="POST" action="" class="p-6" id="delete-form">
                    @csrf
                    @method('DELETE')

                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Are you sure you want to delete this flight?') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('If you are sure, enter the password of your administrator account to confirm it.') }}
                    </p>

                    {{-- Campo de Contraseña --}}
                    <div class="mt-6">
                        <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                            placeholder="{{ __('Password') }}" />
                        <x-input-error :messages="$errors->flightDeletion->get('password')" class="mt-2" />
                    </div>

                    {{-- Botón de Confirmar Eliminación --}}
                    <div class="mt-6 flex justify-center">
                        <x-danger-button x-on:click.prevent="submitForm()">
                            {{ __('Delete flight') }}
                        </x-danger-button>
                    </div>
                </form>
        </x-modal>

        @push('scripts')
            <script>
                $(document).ready(function() {
                    var isAdmin = @json(auth()->user() && auth()->user()->hasRole('admin'));

                    // Definir columnas base
                    var columns = [{
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
                            data: 'seats',
                            name: 'seats',
                            orderable: false
                        },
                        {
                            data: 'departure_date',
                            name: 'departure_date',
                            orderable: false
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            title: isAdmin ? 'Acciones' : 'Comprar' // Cambiar el título de la columna
                        }
                    ];

                    // Si el usuario es administrador, añadir la columna "status"
                    if (isAdmin) {
                        columns.splice(9, 0, {
                            data: 'status',
                            name: 'status',
                            orderable: false
                        });
                    }

                    // Inicializar DataTable con columnas dinámicas
                    var table = $('#flights-table').DataTable({
                        processing: true,
                        serverSide: true,
                        orderable: false,
                        ajax: {
                            url: '{{ route('flights.flightsDatatable') }}',
                            data: function(d) {
                                // Adjuntar filtros
                                const formData = $('#filter-form').serializeArray();
                                formData.forEach(field => {
                                    d[field.name] = field.value;
                                });
                            },
                        },
                        columns: columns, // Usar el array dinámico de columnas
                        language: {
                            paginate: {
                                previous: "<", // Reemplaza "Anterior" con "<"
                                next: ">" // Reemplaza "Siguiente" con ">"
                            },
                        },
                        lengthChange: true,
                        pageLength: 10,
                        info: false,
                        lengthMenu: [10, 20, 30],
                        initComplete: function() {
                            // Mover el buscador predeterminado al contenedor
                            $('#flights-table_filter').appendTo('#custom-search-container');

                            // Mover mostrar registros al contenedor
                            $('#flights-table_length').appendTo('#lengthpage-option');

                            // Mover paginación al contenedor
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

                    // Cerrar el modal al hacer clic fuera de él
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
