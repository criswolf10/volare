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
                    <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-[#22B3B2] hover:bg-opacity-75 text-white rounded-lg">
                        Volver al listado
                    </a>
                </div>
            </x-modal>
        @endif
        {{-- Modal de Error: Cuenta eliminada --}}
        @if (session('error'))
            <x-modal name="flight-delete-error" show="true">
                <div class="text-center py-8">
                    <h3 class="text-xl font-semibold text-red-600">Cuenta eliminada correctamente</h3>
                    <p class="mt-2 text-gray-600">{{ session('error') }}</p>
                </div>
                <div class="flex justify-around mb-6">
                    <a href="{{ route('home') }}"
                        class="px-4 py-2 bg-[#f44336] hover:bg-opacity-75 text-white rounded-lg">volver</a>
                </div>
            </x-modal>
        @endif
        <div class="flex flex-col h-full w-full justify-around p-5 gap-6 shadow-lg rounded-lg">

            <div class="flex flex-col bg-[#E4F2F2] p-4 shadow-lg rounded-lg">
                @include('profile.partials.update-photo-form')
            </div>

            <div class="flex flex-col bg-[#E4F2F2] p-4 shadow-lg rounded-lg">
                @include('profile.partials.update-profile-information-form')

                <div class="flex flex-col bg-[#E4F2F2] p-4 shadow-lg rounded-lg">
                    @include('profile.partials.update-password-form')
                </div>

                <div class="flex flex-col bg-[#E4F2F2] p-4 shadow-lg rounded-lg">
                    @include('profile.partials.delete-user-form')
                </div>

            </div>

        </div>
    @endsection
</x-app-layout>
