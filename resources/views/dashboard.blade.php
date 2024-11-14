<x-app-layout>
    @section('title', 'Volare | Inicio')
    @section('title-page','Dashboard')
    @section('content')

    <div class="flex">
    <div class=" flex">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-teal-200 text-teal-900">
                    <th class="py-2 px-4">Usuario</th>
                    <th class="py-2 px-4">Vuelo</th>
                    <th class="py-2 px-4">Reserva</th>
                    <th class="py-2 px-4">Destino</th>
                    <th class="py-2 px-4">Origen</th>
                    <th class="py-2 px-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Repetir esta fila por cada compra -->

                    <tr class="border-b">
                        <td class="py-2 px-4"></td>
                        <td class="py-2 px-4"></td>
                        <td class="py-2 px-4"></td>
                        <td class="py-2 px-4"></td>
                        <td class="py-2 px-4"></td>
                        <td class="py-2 px-4 flex space-x-2">
                            <button class="text-blue-500 hover:text-blue-700">
                                <!-- Icono de editar -->
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-red-500 hover:text-red-700">
                                <!-- Icono de eliminar -->
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>

            </tbody>
        </table>
    </div>
</section>

<!-- Sección de "Vuelos con plazas vacantes" -->
<section class="w-1/3 bg-white shadow-md rounded-lg p-6">
    <h2 class="text-xl font-bold mb-4">Vuelos con plazas vacantes</h2>
    <div class="space-y-4">

            <div class="bg-teal-50 p-4 rounded-lg">
                <h3 class="text-teal-900 font-semibold"></h3>
                <p class="text-gray-600"></p>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-teal-600 h-2 rounded-full" ></div>
                </div>
                <p class="text-teal-900 text-sm font-semibold mt-1"></p>
            </div>
    </div>
</section>
</div>
    @endsection
</x-app-layout>
