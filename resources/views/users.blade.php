<x-app-layout>
    @section('title', 'Usuarios')
    @section('title-page', 'Listado de usuarios')

    @section('content')
        {{-- Modal de Éxito --}}
        @if (session('success'))
            <x-modal name="user-delete-modal" show="true">
                <!-- Mensaje de éxito -->
                <div class="text-center py-8">
                    <h3 class="text-xl font-semibold text-green-600">¡Usuario eliminado correctamente!</h3>
                    <p class="mt-2 text-gray-600">Pulse en aceptar para volver a gestión de usuarios</p>
                </div>

                <!-- Botón de acción -->
                <div class="flex justify-around mb-6">
                    <a href="{{ route('users') }}" class="px-4 py-2 bg-[#22B3B2] hover:bg-opacity-75 text-white rounded-lg">
                        Aceptar
                    </a>
                </div>
            </x-modal>
        @endif
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
                            <a href="{{ route('create-users') }}">+ Añadir usuario</a>
                        </x-tertiary-button>
                    </div>
                </div>
            </div>

            <!-- Tabla de usuarios -->
            <div class=" overflow-x-auto w-full p-3">
                <table class="table table-bordered justify-center items-center" id="users-table">
                    <thead class="bg-[#22B3B2] text-white uppercase">
                        <tr>
                            <th>Usuario</th>
                            <th>Rol</th>
                            <th>Fecha Registro</th>
                            <th>Email</th>
                            <th>Teléfono</th>
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
        <x-filter-modal title="Filtrar Usuarios" :fields="[
            ['type' => 'date', 'name' => 'start_date', 'label' => 'Fecha de inicio'],
            ['type' => 'date', 'name' => 'end_date', 'label' => 'Fecha de fin'],
            [
                'type' => 'checkbox',
                'name' => 'roles[]',
                'value' => 'admin',
                'label' => 'Administrador',
                'class' => 'role-filter',
            ],
            [
                'type' => 'checkbox',
                'name' => 'roles[]',
                'value' => 'client',
                'label' => 'Cliente',
                'class' => 'role-filter',
            ],
        ]" />


        <x-modal name="user-deletion" :show="false" focusable>
            <div x-data="{
                userId: null,
                open(id) {
                    this.userId = id;
                    this.$dispatch('open-modal', 'user-deletion');
                },
                close() {
                    this.$dispatch('close-modal', 'user-deletion');
                },
                submitForm() {
                    const actionUrl = '/admin/edit-users/' + this.userId;
                    document.getElementById('delete-form').action = actionUrl;
                    document.getElementById('delete-form').submit();
                    this.close(); // Cerrar el modal después de enviar
                }
            }" x-on:user-deletion.window="open($event.detail.userId)">

                <form method="POST" action="" class="p-6" id="delete-form">
                    @csrf
                    @method('DELETE')

                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Are you sure you want to delete this user?') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('If you are sure, enter the password of your administrator account to confirm it.') }}
                    </p>

                    {{-- Campo de Contraseña --}}
                    <div class="mt-6">
                        <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                            placeholder="{{ __('Password') }}" />
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>

                    {{-- Botón de Confirmar Eliminación --}}
                    <div class="mt-6 flex justify-center">
                        <x-danger-button x-on:click.prevent="submitForm()">
                            {{ __('Delete user') }}
                        </x-danger-button>
                    </div>
                </form>
        </x-modal>





        @push('scripts')
            <script>
                $(document).ready(function() {
                    var table = $('#users-table').DataTable({
                        processing: true,
                        serverSide: true,
                        orderable: false,
                        ajax: {
                            url: '{{ route('users.usersDatatable') }}',
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
                                data: 'role',
                                name: 'role',
                                orderable: false
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                                orderable: false
                            },
                            {
                                data: 'email',
                                name: 'email',
                                orderable: false
                            },
                            {
                                data: 'phone',
                                name: 'phone',
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
                            $('#users-table_filter').appendTo('#custom-search-container');

                            //Mover mostrar registros al contenedor
                            $('#users-table_length').appendTo('#lengthpage-option');

                            //Mover paginacion al contenedor
                            $('#users-table_paginate').appendTo('#paginate-option');

                            // Eliminar el texto predeterminado
                            $('#users-table_filter label').contents().filter(function() {
                                return this.nodeType === 3; // Solo los nodos de texto
                            }).remove();

                            $('#users-table_length label').contents().filter(function() {
                                return this.nodeType === 3; // Solo los nodos de texto
                            }).remove();

                            // Cambiar el placeholder
                            $('#users-table_filter input').attr('placeholder', 'Buscar:');
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
