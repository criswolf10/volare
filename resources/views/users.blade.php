<x-app-layout>
    @section('title', 'Usuarios')
    @section('title-page', 'Listado de usuarios')

    @section('content')


        <div class=" p-5 h-full w-full">
            <div class="flex justify-center items-center w-full mb-10 p-3">
                <div class="flex justify-start items-center w-[50%] gap-5">
                    <button class="flex items-center justify-center bg-[#22B3B2] w-10 h-10 rounded cursor-pointer"
                        id="filter-button">
                        <img src="{{ asset('icons/filter.png') }}" class="w-5 h-5">
                    </button>

                    <div id="custom-search-container"></div>
                </div>

                <div class="flex justify-end items-center w-[50%]">
                    <div>
                        <x-tertiary-button>
                            <a href="{{ route('create-users') }}">+ Añadir usuario</a>
                        </x-tertiary-button>
                    </div>
                </div>
            </div>
            <div class=" overflow-x-auto p-3">
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
                    <tbody>

                    </tbody>
                </table>
                <div id="" class="flex justify-start items-center w-full bg-black h-10">
                    <div id="page-option" class="bg-white flex w-full"></div>
                    <div id="" class=""></div>
                </div>
            </div>
        </div>

        <!-- Modal de filtro debajo del botón -->
        <div id="filter-modal" class="absolute hidden mt-2 bg-white shadow-lg p-6 rounded-lg w-96">
            <h3 class="text-xl mb-4">Roles</h3>
            <form id="filter-form">
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="role-filter" value="admin"> Administrador
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="role-filter" value="client"> Cliente
                    </label>
                </div>

                <div class="mt-4 flex justify-between">
                    <button type="button" class="bg-gray-500 text-white py-2 px-4 rounded"
                        id="cancel-filter">Cancelar</button>
                    <button type="submit" class="bg-[#22B3B2] text-white py-2 px-4 rounded">Aplicar</button>
                </div>
            </form>
        </div>


        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('user-delete', ['id' => $user->id]) }}" class="p-6">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-900 ">
                    {{ __('¿Estás seguro que quieres eliminar este usuario?.') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 ">
                    {{ __('Si estas seguro, introduce la contraseña de tu cuenta administrador para eliminarlo.') }}
                </p>

                <div class="mt-6">
                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('Password') }}" />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-center">
                    <x-danger-button>
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
                            url: '{{ route('users.userDatatable') }}',
                            data: function(d) {
                                // Filtrar los roles seleccionados
                                var selectedRoles = [];
                                $('.role-filter:checked').each(function() {
                                    selectedRoles.push($(this).val());
                                });
                                d.roles = selectedRoles; // Agregar roles a los parámetros de la petición
                            }
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
                            url: '/js/datatables/i18n/es-ES.json'
                        },
                        lengthChange: true, // Desactiva la paginación
                        pageLength: 15,
                        info: false, // Desactiva la visualización de los registros
                        lengthMenu: [10, 30, 45],
                        initComplete: function() {
                            // Mover el buscador predeterminado al contenedor
                            $('#users-table_filter').appendTo('#custom-search-container');

                            //Mover paginacion al contenedor
                            $('#users-table_paginate').appendTo('#page-option');

                            //Mover mostrar registros al contenedor
                            $('#users-table_length').appendTo('#page-option');

                            // Eliminar el texto predeterminado
                            $('#users-table_filter label').contents().filter(function() {
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
                document.addEventListener('DOMContentLoaded', () => {
                    Livewire.on('openModal', (modalName, data) => {
                        if (modalName === 'confirm-user-deletion-modal') {
                            const modal = document.querySelector(
                                '[x-data][x-on\\:open-modal\\.window][x-on\\:close-modal\\.window]');
                            const form = modal.querySelector('#delete-user-form');
                            const userId = data.id;

                            // Configurar la acción del formulario
                            form.action = `/users/${userId}`;

                            // Mostrar el modal
                            modal.__x.$data.show = true;
                        }
                    });
                });
            </script>
        @endpush

    @endsection
</x-app-layout>
