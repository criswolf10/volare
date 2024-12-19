<x-app-layout>
    @section('title', 'Perfil')

    @section('title-page', 'Editar Perfil')

    @section('content')
        {{-- Modal de Éxito --}}
        @if (session('update-photo-success'))
            <x-modal name="update-photo-success-modal" show="true">
                <!-- Mensaje de éxito -->
                <div class="text-center py-8">
                    <h3 class="text-xl font-semibold text-green-600">¡Usuario eliminado correctamente!</h3>
                </div>

                <!-- Botón de acción -->
                <div class="flex justify-around mb-6">
                    <a href="{{ route('profile.edit') }}"
                        class="px-4 py-2 bg-[#22B3B2] hover:bg-opacity-75 text-white rounded-lg">
                        Volver al listado
                    </a>
                </div>
            </x-modal>
        @endif

        <div class="flex flex-col h-full w-full justify-center items-center p-3 gap-2 shadow-lg rounded-lg">
            <div class="flex flex-col sm:w-full md:w-full lg:w-full xl:flex-row justify-center gap-5 p-5 w-full">
                <!-- Contenedor para las secciones de actualización de foto, perfil y contraseña -->
                <div class="bg-[#E4F2F2] p-5 shadow-lg rounded-lg w-full sm:w-full md:w-full xl:w-[30%] mb-5 xl:mb-0">
                    @include('profile.partials.update-photo-form')
                </div>
                <div class="bg-[#E4F2F2] p-5 shadow-lg rounded-lg w-full sm:w-full md:w-full xl:w-[30%] mb-5 xl:mb-0">
                    @include('profile.partials.update-profile-information-form')
                </div>
                <div class="bg-[#E4F2F2] p-5 shadow-lg rounded-lg w-full sm:w-full md:w-full xl:w-[30%] mb-5 xl:mb-0">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            <div class="bg-[#E4F2F2] p-5 shadow-lg rounded-lg w-full xl:w-[90%]">
                <!-- Formulario de eliminación de cuenta -->
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    @endsection
</x-app-layout>
