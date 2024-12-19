<section>
    <div class="flex flex-col justify-start bg-white shadow-lg rounded-lg p-6 gap-6">
        <h2 class="text-2xl xl:text-3xl font-semibold text-gray-900 mb-4">
            {{ __('Vuelo') }} {{ $flight->code }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 font-semibold">
            {{ __('Actualiza los datos del vuelo') }}
        </p>

        <form method="POST" action="{{ route('flights.update', ['id' => $flight->id]) }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Campos no editables (código de vuelo, origen, destino, duración, precio y tipo de asientos) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <x-input-label for="code">Código del Vuelo</x-input-label>
                    <x-text-input id="code" name="code" value="{{ old('code', $flight->code) }}" readonly
                        class="opacity-50 bg-gray-100 cursor-not-allowed"></x-text-input>
                </div>
                <div>
                    <x-input-label for="aircraft_id"
                        class="block text-sm font-medium text-gray-700">Avión</x-input-label>
                    <x-text-input type="text" id="aircraft_id" name="aircraft_id"
                        value="{{ $flight->aircraft->name }}" readonly
                        class="opacity-50 bg-gray-100 cursor-not-allowed"></x-text-input>
                </div>
                <div>
                    <x-input-label for="origin">Origen</x-input-label>
                    <x-text-input id="origin" name="origin" value="{{ old('origin', $flight->origin) }}" readonly
                        class="opacity-50 bg-gray-100 cursor-not-allowed"></x-text-input>
                </div>

                <div>
                    <x-input-label for="destination">Destino</x-input-label>
                    <x-text-input id="destination" name="destination"
                        value="{{ old('destination', $flight->destination) }}" readonly
                        class="opacity-50 bg-gray-100 cursor-not-allowed"></x-text-input>
                </div>

                <div>
                    <x-input-label for="duration">Duración</x-input-label>
                    <x-text-input id="duration" name="duration" value="{{ \Carbon\Carbon::parse($flight->duration)->format('H \h\o\r\a\s i \m\i\n\u\t\o\s') }}" readonly
                        class="opacity-50 bg-gray-100 cursor-not-allowed"></x-text-input>
                </div>

                <div>
                    <x-input-label for="price">Precio</x-input-label>
                    <x-text-input id="price" name="price" value="Desde {{ $flight->aircraft->seats->min('price') }} €" readonly
                        class="opacity-50 bg-gray-100 cursor-not-allowed"></x-text-input>
                </div>

                <div>
                    <x-input-label for="seats">Clases</x-input-label>
                    <x-text-input id="seats" name="seats" value="{{ implode(', ', $flight->aircraft->seats->pluck('class')->unique()->take(3)->toArray()) }}" readonly
                        class="opacity-50 bg-gray-100 cursor-not-allowed"></x-text-input>
                </div>

            </div>

            <!-- Fecha y hora del vuelo -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="departure_date">Fecha del Vuelo</x-input-label>
                    <x-text-input type="date" id="departure_date" name="departure_date"
                        value="{{ old('departure_date', $flight->departure_date) }}"
                        min="{{ now()->addDays(3)->toDateString() }}"></x-text-input>
                    @error('departure_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label for="departure_time">Hora de salida</x-input-label>
                    <x-text-input type="time" id="departure_time" name="departure_time"
                        value="{{ \Carbon\Carbon::parse(old('departure_time', $flight->departure_time))->format('H:i') }}"
                        class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></x-text-input>
                    @error('departure_time')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="arrival_time">Hora de llegada</x-input-label>
                    <x-text-input type="time" id="arrival_time" name="arrival_time"
                        value="{{ \Carbon\Carbon::parse(old('arrival_time', $flight->arrival_time))->format('H:i') }}"
                        class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></x-text-input>
                    @error('arrival_time')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex justify-center items-center gap-4 mb-3 xl:w-[50%]">
                <x-tertiary-button class="px-6 py-3 text-lg">
                    {{ __('Guardar') }}
                </x-tertiary-button>

                <x-danger-button class="px-6 py-3 text-lg">
                    <a href="{{ route('flights') }}">{{ __('Cancelar') }}</a>
                </x-danger-button>
            </div>
        </form>
    </div>

    <!-- Sección de cancelación de vuelo -->
    <div class="flex flex-col justify-start bg-white shadow-lg rounded-lg p-6 gap-6 mt-6" x-data="{ modalOpen: false }">
        <h2 class="text-lg xl:text-2xl font-medium text-gray-900">
            {{ __('Cancelar Vuelo') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 xl:w-[50%] font-semibold">
            {{ __('Una vez que el vuelo sea cancelado, todos los datos asociados serán eliminados permanentemente y se le notificara a los usuarios que hayan comprado billetes para este vuelo.') }}
        </p>

        <x-danger-button class="xl:w-[25%]" x-on:click.prevent="$dispatch('open-modal', 'flight-deletion')">
            {{ __('Cancelar vuelo') }}
        </x-danger-button>

        <!-- Modal de Confirmación de Eliminación -->
        <x-modal name="flight-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="POST" action="{{ route('flights.delete', ['id' => $flight->id]) }}" class="p-6">
                @csrf
                @method('DELETE')

                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('¿Estás seguro de que deseas eliminar el vuelo :flight?', ['flight' => $flight->code]) }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Si estás seguro, ingresa la contraseña de tu cuenta de administrador para confirmarlo.') }}
                </p>

                {{-- Campo de Contraseña --}}
                <div class="mt-6">
                    <x-input-label for="password" value="{{ __('Contraseña') }}" class="sr-only" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('Contraseña') }}" />
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
