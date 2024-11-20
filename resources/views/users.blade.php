<x-app-layout>
    @section('title', 'Usuarios')
    @section('title-page', 'Listado de usuarios')

    @section('content')
        <div class=" p-5 overflow-x-auto h-full">

            <table class="table table-bordered" id="users-table">
                <thead class="bg-[#909494] text-white uppercase">
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
        </div>


        @push('scripts')
            <script>
                $(document).ready(function() {
                    $('#users-table').DataTable({
                        processing: true,
                        serverSide: true,
                        orderable: false,
                        ajax: '{{ route('users.getUserData') }}',

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
