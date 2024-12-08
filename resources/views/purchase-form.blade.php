<x-app-layout>

@section('content')
<section>
    <div class="flex flex-col justify-start bg-white shadow-lg rounded-lg p-5 gap-2">
        <h2 class="text-lg xl:text-3xl font-semibold text-gray-900">
            {{ __('Compra tu billete de vuelo') }}
        </h2>

        <form method="POST" action="{{ route('tickets.purchase') }}" class="mt-4">
            @csrf
            <div class="mb-3">
                <x-input-label for="flight_code" value="{{ __('Código del vuelo') }}" class="block text-sm font-medium text-gray-700" />
                <x-text-input type="text" name="flight_code" id="flight_code" class="mt-1 block w-full" value="{{ old('flight_code', $flight->flight_code) }}" required />
            </div>

            <div class="mb-3">
                <x-input-label for="passenger_name" value="{{ __('Nombre del pasajero') }}" class="block text-sm font-medium text-gray-700" />
                <x-text-input type="text" name="passenger_name" id="passenger_name" class="mt-1 block w-full" required />
            </div>

            <div class="mb-3">
                <x-input-label for="seat_class" value="{{ __('Clase de asiento') }}" class="block text-sm font-medium text-gray-700" />
                <x-text-input type="text" name="seat_class" id="seat_class" class="mt-1 block w-full" value="{{ old('seat_class', $flight->seat) }}" required />
            </div>

            <div class="flex items-center gap-4 mb-3 xl:w-[50%]">
                <x-tertiary-button>
                    {{ __('Comprar Billete') }}
                </x-tertiary-button>
                <x-danger-button>
                    <a href="{{ route('flights') }}">{{ __('Cancelar') }}</a>
                </x-danger-button>
            </div>
        </form>

    </div>
</section>
@endsection
</x-app-layout>
