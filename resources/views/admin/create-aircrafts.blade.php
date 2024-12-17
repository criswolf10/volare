<x-app-layout>
    @section('title', 'Gestión de vuelos')

    @section('title-page', 'Crear vuelo')

    @section('content')
        <!-- Verificar si hay un mensaje de éxito en la sesión y mostrar el modal -->
        @if (session('success'))
            <x-modal show="true" name="user-create-modal">
                <!-- Mensaje de éxito -->
                <div class="text-center py-8">
                    <h3 class="text-xl font-semibold text-green-600">Avión creado correctamente!</h3>
                    <p class="mt-2 text-gray-600">El avión ha sido añadido correctamente. ¿Qué deseas hacer ahora?</p>
                </div>

                <!-- Botones -->
                <div class="flex justify-around mb-6">
                    <a href="{{ route('flights.create') }}"
                        class="px-4 py-2 bg-[#22B3B2] hover:bg-opacity-75 text-white rounded-lg">Crear Un vuelo</a>
                    <a href="{{ route('flights') }}"
                        class="px-4 py-2 hover:bg-gray-500 text-white rounded-lg bg-gray-600">Volver al listado de vuelos</a>
                </div>
            </x-modal>
        @endif
        <div class="flex flex-col h-full w-full justify-around p-5 gap-6 shadow-lg rounded-lg">
            <div class="flex flex-col bg-[#E4F2F2] p-4 shadow-lg rounded-lg">
                <section>
                    <div class="flex flex-col justify-start bg-white shadow-lg rounded-lg p-5 gap-2">
                        <h2 class="text-lg xl:text-3xl font-semibold text-gray-900">
                            {{ __('Introduce los datos del nuevo avion') }}
                        </h2>

                        <form method="POST" action="{{ route('aircraft.store') }}" class="mt-4">
                            @csrf


                            <div class="mb-3">
                                <x-input-label for="origin" class="block text-sm font-medium text-gray-700" />
                                <x-text-input type="text" name="origin" id="origin" class="mt-1 block w-full" />
                            </div>

                            <div class="mb-3">
                                <x-input-label for="destination" class="block text-sm font-medium text-gray-700" />
                                <x-text-input type="text" name="destination" id="destination" class="mt-1 block w-full" />
                            </div>

                            <div class="mb-3">
                                <x-input-label for="duration" class="block text-sm font-medium text-gray-700" />
                                <x-text-input type="text" name="duration" id="duration" class="mt-1 block w-full" />
                            </div>

                            <div class="mb-3">
                                <x-input-label for="departure_date" class="block text-sm font-medium text-gray-700" />
                                <x-text-input type="date" name="departure_date" id="departure_date" class="mt-1 block w-full" />
                            </div>

                            <div class="mb-3">
                                <x-input-label for="seats_class" class="block text-sm font-medium text-gray-700" />
                                <x-text-input type="text" name="seats_class" id="seats_class" class="mt-1 block w-full" />
                            </div>

                            <div class="flex items-center gap-4 mb-3 xl:w-[50%]">
                                <x-tertiary-button type="submit">
                                    {{ __('Crear avión') }}
                                </x-tertiary-button>
                                <x-danger-button>
                                    <a href="{{ route('flights.create') }}">{{ __('Cancelar') }}</a>
                                </x-danger-button>
                            </div>
                        </form>
                    </div>
                </section>

            </div>
        </div>
    @endsection
</x-app-layout>
