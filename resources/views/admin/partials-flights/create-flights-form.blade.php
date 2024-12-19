<section>
    <div class="bg-white shadow-lg rounded-lg p-5 md:p-8 lg:p-10 space-y-6">
        <h2 class="text-xl md:text-2xl xl:text-3xl font-semibold text-gray-900 text-center lg:text-left">
            {{ __('Introduce los datos del nuevo vuelo') }}
        </h2>

        <form method="POST" action="{{ route('flights.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <x-input-label for="code" class="block text-sm font-medium text-gray-700" />
                    Código del vuelo
                    <x-text-input type="text" name="code" id="code"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm " />
                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="origin" class="block text-sm font-medium text-gray-700" />
                    Origen
                    <x-text-input type="text" name="origin" id="origin"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm " />
                    <x-input-error :messages="$errors->get('origin')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="destination" class="block text-sm font-medium text-gray-700" />
                    Destino
                    <x-text-input type="text" name="destination" id="destination"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm " />
                    <x-input-error :messages="$errors->get('destination')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="departure_date" class="block text-sm font-medium text-gray-700" />
                    Fecha de salida
                    <x-text-input type="date" name="departure_date" id="departure_date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm " />
                    <x-input-error :messages="$errors->get('departure_date')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="departure_time" class="block text-sm font-medium text-gray-700" />
                    Hora de salida
                    <x-text-input type="time" name="departure_time" id="departure_time"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('departure_time') }} " />
                    <x-input-error :messages="$errors->get('departure_time')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="arrival_time" class="block text-sm font-medium text-gray-700" />
                    Hora de llegada
                    <x-text-input type="time" name="arrival_time" id="arrival_time"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm " value="{{ old('arrival_time') }}" />
                    <x-input-error :messages="$errors->get('arrival_time')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="duration" class="block text-sm font-medium text-gray-700" />
                    Duración
                    <x-text-input type="text" name="duration" id="duration"
                        class="mt-1 block w-full rounded-md opacity-50 bg-gray-100 cursor-not-allowed shadow-sm "
                        readonly />
                </div>

                <div>
                    <x-input-label for="aircraft_id" class="block text-sm font-medium text-gray-700" />
                    Elige el avión para el vuelo o tal vez quiera
                    <a href="{{ route('aircrafts.create') }}" class="text-blue-500 hover:underline">crear un avión</a>
                    <select name="aircraft_id" id="aircraft_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm "
                        onchange="updateClassAndPrice()">
                        <option value="">Selecciona un avión disponible</option>
                        @foreach ($aircrafts as $aircraft)
                            <option value="{{ $aircraft->id }}"
                                data-class="{{ implode(',', $aircraft->unique_classes) }}"
                                data-price="{{ implode(',', $aircraft->unique_prices) }}">
                                {{ $aircraft->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div>
                    <x-input-label for="class" class="block text-sm font-medium text-gray-700" />
                    Clases disponibles
                    <x-text-input type="text" name="class" id="class"
                        class="mt-1 block w-full rounded-md opacity-50 bg-gray-100 cursor-not-allowed shadow-sm" readonly />
                </div>

                <div>
                    <x-input-label for="price" class="block text-sm font-medium text-gray-700" />
                    Precios por clase
                    <x-text-input type="text" name="price" id="price"
                        class="mt-1 block w-full rounded-md opacity-50 bg-gray-100 cursor-not-allowed shadow-sm" readonly />
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-center lg:justify-start gap-4 mt-6">
                <x-tertiary-button type="submit" class="w-full sm:w-auto">
                    {{ __('Crear vuelo') }}
                </x-tertiary-button>
                <x-danger-button class="w-full sm:w-auto">
                    <a href="{{ route('flights') }}">{{ __('Cancelar') }}</a>
                </x-danger-button>
            </div>
        </form>
    </div>
</section>
<script>
    function updateClassAndPrice() {
        var aircraftSelect = document.getElementById("aircraft_id");
        var selectedOption = aircraftSelect.options[aircraftSelect.selectedIndex];

        // Obtener las clases y precios desde los datos del avión seleccionado
        var classes = selectedOption.getAttribute("data-class");
        var prices = selectedOption.getAttribute("data-price");

        // Actualizar los campos de clase y precio
        document.getElementById("class").value = classes;
        document.getElementById("price").value = prices;
    }
</script>
