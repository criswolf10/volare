<section>
    <div class="flex flex-col justify-start bg-white shadow-lg rounded-lg p-5 gap-2">
        <h2 class="text-lg xl:text-3xl font-semibold text-gray-900">
            {{ __('Vuelo') }} {{ $flight->code }}
        </h2>
        </h2>

        <p class="mt-1 text-sm text-gray-600 font-semibold">
            {{ __('Update the flight data') }}
        </p>

        <form method="POST" action="{{ route('flights.update', $flight->id) }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Campos: code, origin, destination, price , duracion, no editables, ni marcables y con opacidad -->
            <div>
                <x-input-label for="code">Código del Vuelo</x-input-label>
                <x-text-input id="code" name="code" value="{{ old('code', $flight->code) }}" readonly
                    class="opacity-50 bg-gray-100 cursor-not-allowed"></x-text-input>
            </div>

            <div>
                <x-input-label for="origin">Origen</x-input-label>
                <x-text-input id="origin" name="origin" value="{{ old('origin', $flight->origin) }}" readonly
                    class="opacity-50 bg-gray-100 cursor-not-allowed"></x-text-input>
            </div>

            <div>
                <x-input-label for="destination">Destino</x-input-label>
                <x-text-input id="destination" name="destination" value="{{ old('destination', $flight->destination) }}"
                    readonly class="opacity-50 bg-gray-100 cursor-not-allowed"></x-text-input>
            </div>

            <!-- Precios por clase de asiento -->


            <div>
                <x-input-label for="duration">Duración</x-input-label>
                <x-text-input id="duration" name="duration" value="{{ $flight->duration }}" readonly
                    class="opacity-50 bg-gray-100 cursor-not-allowed"></x-text-input>
            </div>

            <!-- Aircraft Selection -->
            <div>
                <x-input-label for="aircraft_id" class="block text-sm font-medium text-gray-700">Avión</x-input-label>
                <x-text-input type="text" id="aircraft_id" name="aircraft_id" value="{{ $flight->aircraft->name }}" 
                    readonly class="opacity-50 bg-gray-100 cursor-not-allowed"></x-text-input>
            </div>


            <!-- Campo: Fecha del Vuelo (departure_date) -->
            <div>
                <x-input-label for="departure_date">Fecha del Vuelo</x-input-label>
                <x-text-input type="date" id="departure_date" name="departure_date"
                    value="{{ old('departure_date', $flight->departure_date) }}"
                    min="{{ now()->addDays(3)->toDateString() }}"></x-text-input>
                @error('departure_date')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <!-- Departure Time -->
            <div>
                <x-input-label for="departure_time" class="block text-sm font-medium text-gray-700">Hora de
                    salida</x-input-label>
                <x-text-input type="time" id="departure_time" name="departure_time"
                    value="{{ \Carbon\Carbon::parse(old('departure_time', $flight->departure_time))->format('H:i') }}"
                    class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></x-text-input>
                @error('departure_time')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Arrival Time -->
            <div>
                <x-input-label for="arrival_time" class="block text-sm font-medium text-gray-700">Hora de
                    llegada</x-input-label>
                <x-text-input type="time" id="arrival_time" name="arrival_time"
                    value="{{ \Carbon\Carbon::parse(old('arrival_time', $flight->arrival_time))->format('H:i') }}"
                    class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></x-text-input>
                @error('arrival_time')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

        <div class="flex justify-center items-center gap-4 mb-3 xl:w-[50%]">
            <x-tertiary-button>{{ __('Save') }}</x-tertiary-button>

            <x-danger-button>
                <a href="{{ route('users') }}">{{ __('Cancelar') }}</a>
            </x-danger-button>
        </div>
        </form>
</section>

<div class="flex flex-col justify-start bg-white shadow-lg rounded-lg p-5 gap-2" x-data="{ modalOpen: false }">
    <h2 class="text-lg xl:text-2xl font-medium text-gray-900">
        {{ __('Cancelar Vuelo') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600 xl:w-[50%] font-semibold">
        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.') }}
    </p>

    {{-- Botón de eliminar usuario --}}
    <x-danger-button class="xl:w-[25%]" x-on:click.prevent="$dispatch('open-modal', 'flight-deletion')">
        {{ __('Cancelar') }}
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
                    {{ __('Cancelar vuelo') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>

</div>
</section>
