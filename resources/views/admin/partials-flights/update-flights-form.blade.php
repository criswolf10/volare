<section>
    <div class="flex flex-col justify-start bg-white shadow-lg rounded-lg p-5 gap-2">
        <h2 class="text-lg xl:text-3xl font-semibold text-gray-900">
            {{ __('flight information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 font-semibold">
            {{ __('Update the flight data') }}
        </p>

        <form method="post" action="{{ route('flights.update', $flight->id) }}">
            @csrf
            @method('patch')

            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="aircraft" :value="__('Aircraft')" />
                <x-select id="aircraft" name="aircraft" class="mt-1 block w-full">
                    <option value="">{{ __('Select an aircraft') }}</option>
                    @foreach ($aircrafts as $aircraft)
                        <option value="{{ $aircraft->id }}" @if ($aircraft->id == old('aircraft', $flight->aircraft_id)) selected @endif>
                            {{ $aircraft->model }}
                        </option>
                    @endforeach

            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="code" :value="__('Code')" />
                <x-text-input id="code" name="code" type="text" class="mt-1 block" />
                <x-input-error class="mt-2" :messages="$errors->get('code')" />
            </div>

            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="departure_date" :value="__('Departure_date')" />
                <x-text-input id="departure_date" name="departure" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('departure_date')" />
            </div>

            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="departure_time" :value="__('Departure Time')" />
                <x-text-input id="departure_time" name="departure_time" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('departure_time')" />
            </div>

            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="arrival_time" :value="__('Arrival Time')" />
                <x-text-input id="arrival_time" name="arrival_time" type="text" class="mt-1 block w-full" value="{{ old('arrival_time', $flight)}}" />
                <x-input-error class="mt-2" :messages="$errors->get('arrival_time')" />
            </div>

            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="price" :value="__('Price')" />
                <x-text-input id="price" name="price" type="text" class="mt-1 block w-full" value="{{ old('price', $ticketPrice) }}" />
                <x-input-error class="mt-2" :messages="$errors->get('price')" />
            </div>


            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="seats" :value="__('Seats')" />
                <x-text-input id="seats" name="seats" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('seats')" />
            </div>

            <div class="flex justify-center items-center gap-4 mb-3 xl:w-[50%]">
                <x-tertiary-button>{{ __('Save') }}</x-tertiary-button>

                <x-danger-button>
                    <a href="{{ route('users') }}">{{ __('Cancelar') }}</a>
                </x-danger-button>
            </div>

</section>

{{-- Sección de Eliminación --}}
<section class="space-y-6 mt-5">
    {{-- Modal de Éxito --}}
    @if (session('success'))
        <x-modal name="flight-delete-modal" show="true">
            <!-- Mensaje de éxito -->
            <div class="text-center py-8">
                <h3 class="text-xl font-semibold text-green-600">¡Vuelo eliminado correctamente!</h3>
                <p class="mt-2 text-gray-600">Pulse en aceptar para volver a gestión de vuelos</p>
            </div>

            <!-- Botón de acción -->
            <div class="flex justify-around mb-6">
                <a href="{{ route('flights') }}"
                    class="px-4 py-2 bg-[#22B3B2] hover:bg-opacity-75 text-white rounded-lg">
                    Aceptar
                </a>
            </div>
        </x-modal>
    @endif


    <div class="flex flex-col justify-start bg-white shadow-lg rounded-lg p-5 gap-2" x-data="{ modalOpen: false }">
        <h2 class="text-lg xl:text-2xl font-medium text-gray-900">
            {{ __('Delete flight') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 xl:w-[50%] font-semibold">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.') }}
        </p>

        {{-- Botón de eliminar usuario --}}
        <x-danger-button class="xl:w-[25%]" x-on:click.prevent="$dispatch('open-modal', 'flight-deletion')">
            {{ __('Delete Account') }}
        </x-danger-button>

        <!-- Modal de Confirmación de Eliminación -->
        <x-modal name="flight-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="POST" action="{{ route('flights.delete', ['id' => $flight->id]) }}" class="p-6">
                @csrf
                @method('DELETE')

                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Are you sure you want to delete this flight :flight?', ['flight' => $flight->code]) }}
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
                    <x-danger-button>
                        {{ __('Delete flight') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>

    </div>
</section>
