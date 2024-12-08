<section>
    <div class="flex flex-col justify-start bg-white shadow-lg rounded-lg p-5 gap-2">
        <h2 class="text-lg xl:text-3xl font-semibold text-gray-900">
            {{ __('Introduce los datos del nuevo vuelo') }}
        </h2>

        <form method="POST" action="{{ route('flights.store') }}" class="mt-4">
            @csrf
            <div class="mb-3">
                <x-input-label for="flight_code" class="block text-sm font-medium text-gray-700" />
                <x-text-input type="text" name="flight_code" id="flight_code" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('flight_code')" class="mt-2" />
            </div>

            <div class="mb-3">
                <x-input-label for="aircraft" class="block text-sm font-medium text-gray-700" />
                <select name="aircraft" id="aircraft" class="mt-1 block w-full">
                    <option value="">Selecciona un avión disponible</option>
                    @foreach ($aircrafts as $aircraft)
                        <option value="{{ $aircraft->id }}">{{ $aircraft->name }}</option>
                    @endforeach
                </select>
            </div>

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
                    {{ __('Crear vuelo') }}
                </x-tertiary-button>
                <x-danger-button>
                    <a href="{{ route('flights') }}">{{ __('Cancelar') }}</a>
                </x-danger-button>
            </div>
        </form>
    </div>
</section>
