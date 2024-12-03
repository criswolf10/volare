<x-app-layout>
    @section('title', 'Gestión de usuarios')

    @section('title-page', 'Crear usuario')

    @section('content')
        <!-- Verificar si hay un mensaje de éxito en la sesión y mostrar el modal -->
        @if (session('success'))
            <x-modal show="true" name="user-create-modal">
                <!-- Mensaje de éxito -->
                <div class="text-center py-8">
                    <h3 class="text-xl font-semibold text-green-600">¡Usuario creado correctamente!</h3>
                    <p class="mt-2 text-gray-600">El usuario ha sido añadido correctamente. ¿Qué deseas hacer ahora?</p>
                </div>

                <!-- Botones -->
                <div class="flex justify-around mb-6">
                    <a href="{{ route('user-create') }}"
                        class="px-4 py-2 bg-[#22B3B2] hover:bg-opacity-75 text-white rounded-lg">Añadir más usuarios</a>
                    <a href="{{ route('users') }}"
                        class="px-4 py-2 hover:bg-gray-500 text-white rounded-lg bg-gray-600">Volver al listado</a>
                </div>
            </x-modal>
        @endif
        <div class="flex flex-col h-full w-full justify-around p-5 gap-6 shadow-lg rounded-lg">
            <div class="flex flex-col bg-[#E4F2F2] p-4 shadow-lg rounded-lg">
                @include('admin.partials-users.create-users-form')
            </div>
        </div>
    @endsection
    </x-guest-layout>
