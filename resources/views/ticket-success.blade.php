<x-app-layout>
    @section('title', 'Tarjeta de Embarque')
    @section('title-page', 'Tarjeta de Embarque')
    @section('content')
        <div class="bg-white p-6 flex justify-center items-center mt-6">
            <div class="flex justify-center items-center bg-[#E4F2F2] w-full p-6 rounded-lg shadow-md">
                <!-- Tarjeta de embarque -->
                <div class="flex flex-col w-full justify-center items-center bg-white p-6 rounded-lg shadow-lg gap-3">
                    <!-- Parte superior con detalles -->
                    <div class="flex justify-center items-center w-full p-5">
                        <!-- Logo de la aerolínea -->
                        <div class="flex justify-center items-center w-[50%] rounded-lg ">
                            <img src="{{ asset('img/logo-invoice.png') }}" alt="volare-index" class="w-16 h-16">
                        </div>
                        <div class="flex justify-center items-center w-[50%] text-2xl font-semibold text-teal-700 gap-3 ">
                            <img src="{{ asset('icons/flights.svg') }}" alt="boarding-pass" class="w-10 h-10">
                            <h3 class="text-xl font-bold text-gray-700 uppercase">Vuelo:</h3>
                            <p class="text-xl font-semibold text-gray-600">{{ $ticket->flight->code }}</p>

                        </div>
                    </div>

                    <!-- Detalles del vuelo y pasajero -->
                    <div class="flex border-t-4 border-teal-400 w-full gap-6">
                        <div class="flex flex-col justify-start items-start w-[30%] mt-5 gap-4 p-3">
                            <!-- Numero de billete -->
                            <div class="flex justify-center items-center gap-3 w-full">
                                <h3 class="text-xl font-bold text-gray-700 uppercase">Nº Billete:</h3>
                                <p class="text-xl font-semibold text-gray-600">{{ $ticket->booking_code }}</p>
                            </div>

                            <!-- Código de barras o código QR  -->
                            <div class="flex flex-col justify-center items-center p-5 w-full">
                                {{-- {!! $qrCode !!} --}}
                            </div>
                        </div>

                        <div class="flex flex-col justify-start items-start w-[60%]">
                            <!-- Información del pasajero -->
                            <div class="flex justify-center items-center w-full mt-3">
                                <h3 class="text-2xl font-bold text-gray-700 uppercase ">Detalles del Vuelo</h3>
                            </div>
                            <div class="flex ">

                                <!-- Información de vuelo -->
                                <div class=" flex flex-col justify-center items-center">
                                    <div class="flex justify-start items-center gap-3 w-full mt-4">
                                        <h4 class="text-xl font-bold text-gray-700 uppercase">Pasajero:</h4>
                                        <p class="text-xl font-semibold text-gray-600">{{ $ticket->passenger->name }}
                                            {{ $ticket->passenger->lastname }}</p>
                                    </div>
                                    <div class="flex mt-4 w-full gap-6">
                                        <div>
                                            <h4 class="text-xl font-bold text-gray-700 uppercase">Origen:</h4>
                                            <p class="text-xl font-semibold text-gray-600">{{ $ticket->flight->origin }}</p>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-bold text-gray-700 uppercase">Destino:</h4>
                                            <p class="text-xl font-semibold text-gray-600">{{ $ticket->flight->destination }}</p>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-bold text-gray-700 uppercase">Zona de asientos</h4>
                                            <p class="text-center text-xl font-semibold text-gray-600">{{ $ticket->seat->class }}</p>
                                        <div>
                                            <h4 class="text-xl font-bold text-gray-700 uppercase">Nº Asiento:</h4>
                                            <p class="text-center text-xl font-semibold text-gray-600">{{ $ticket->seat->seat_code }}</p>
                                        </div>

                                    </div>
                                    <div class="flex mt-4 w-full gap-16">
                                        <div>
                                            <h4 class="text-xl font-bold text-gray-700 uppercase">Fecha:</h4>
                                            <p class="text-xl font-semibold text-gray-600">{{ \Carbon\Carbon::parse($ticket->flight->date)->format('d/m/Y') }}</p>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-bold text-gray-700 uppercase">salida:</h4>
                                            <p class="text-center text-xl font-semibold text-gray-600">{{ \Carbon\Carbon::parse($ticket->flight->departure_time)->format('H:i')  }}</p>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-bold text-gray-700 uppercase">llegada:</h4>
                                            <p class="text-center text-xl font-semibold text-gray-600">{{ \Carbon\Carbon::parse($ticket->flight->arrival_time)->format('H:i')  }}</p>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-bold text-gray-700 uppercase">Precio:</h4>
                                            <p class="text-xl font-semibold text-gray-600">{{ $ticket->seat->price }} €</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <!-- Botón de descarga (fuera de la vista PDF) -->
                        <div class=" flex justify-center items-center w-[10%] mr-10">
                            <x-tertiary-button>
                                <a href="{{ route('tickets.invoice', ['id' => $ticket->id]) }}">Descargar</a>
                            </x-tertiary-button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
