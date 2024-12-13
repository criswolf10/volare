<x-app-layout>
    @section('title', 'Ventas')
    @section('title-page', 'Listado de ventas')

    @section('content')
    <div class=" p-5 h-full w-full">
        <div class="flex justify-start items-center w-full mb-6 p-3">

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

        </div>

        <!-- Tabla de usuarios -->
        <div class=" overflow-x-auto w-full p-3">
            <table class="table border-collapse justify-center items-center" id="tickets-table">
                <thead class="bg-[#22B3B2] text-white uppercase ">
                    <tr>
                        <th>Usuario</th>
                        <th>vuelo</th>
                        <th>origen</th>
                        <th>destino</th>
                        <th>duración</th>
                        <th>cantidad</th>
                        <th>precio</th>
                        <th>Nº asiento</th>
                        <th>fecha de compra</th>
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

    <!-- Modal de filtro de usuarios -->
    {{-- <x-filter-modal title="" /> --}}

    @push('scripts')
        <script>
            $(document).ready(function() {
                var table = $('#tickets-table').DataTable({
                    processing: true,
                    serverSide: true,
                    orderable: false,
                    ajax: {
                        url: '{{ route('tickets.ticketsDatatable') }}',
                        data: function(d) {
                            // Adjuntar filtros
                            const formData = $('#filter-form').serializeArray();
                            formData.forEach(field => {
                                d[field.name] = field.value;
                            });
                        },
                    },
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
                            data:'quantity',
                            name:'quantity',
                            orderable:false
                        },
                        {
                            data: 'price',
                            name: 'price',
                            orderable: false
                        },
                        {
                            data: 'seat',
                            name: 'seat',
                            orderable: false
                        },
                        {
                            data: 'purchase_date',
                            name: 'purchase_date',
                            orderable: false
                        },

                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        }
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
                        $('#tickets-table_filter').appendTo('#custom-search-container');

                        //Mover mostrar registros al contenedor
                        $('#tickets-table_length').appendTo('#lengthpage-option');

                        //Mover paginacion al contenedor
                        $('#tickets-table_paginate').appendTo('#paginate-option');

                        // Eliminar el texto predeterminado
                        $('#tickets-table_filter label').contents().filter(function() {
                            return this.nodeType === 3; // Solo los nodos de texto
                        }).remove();

                        $('#tickets-table_length label').contents().filter(function() {
                            return this.nodeType === 3; // Solo los nodos de texto
                        }).remove();

                        // Cambiar el placeholder
                        $('#tickets-table_filter input').attr('placeholder', 'Buscar:');
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
                document.addEventListener('alpine:init', () => {
                    Alpine.data('userDeletion', () => ({
                        userId: null, // Inicializa el ID del usuario
                        open(id) {
                            this.userId = id;
                            // Abre el modal de confirmación de eliminación
                            this.$dispatch('open-modal', 'user-deletion');
                        },
                        submitForm() {
                            // Modifica la URL de eliminación para incluir el id del usuario
                            const actionUrl = '/admin/edit-users/' + this
                            .userId; // Construye la URL con el ID del usuario
                            document.getElementById('delete-form').action = actionUrl;
                            document.getElementById('delete-form').submit(); // Envía el formulario

                            this.$dispatch('close-modal',
                            'user-deletion'); // Cerrar el modal después de enviar

                        }
                    }));
                });
            });
        </script>
    @endpush

@endsection
</x-app-layout>
