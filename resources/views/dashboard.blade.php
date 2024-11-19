<x-app-layout>
    @section('title', 'Dashboard')
    @section('title-page', 'Dashboard')
    @section('content')

        <div class="flex flex-col w-full p-5 xl:flex-row gap-5">
            <section class="flex flex-col bg-[#E4F2F2] h-full w-full shadow-md rounded-lg p-5 xl:w-[60%]">
                <!-- Contenedor de la tabla con overflow horizontal -->
                <div class="overflow-x-auto h-full">

                </div>
            </section>

            <!-- Sección de "Vuelos con plazas vacantes" -->
            <section class="flex flex-col bg-[#E4F2F2] h-full w-full shadow-md rounded-lg p-5 xl:w-[40%]">
                <div class="overflow-x-auto"></div>
                <div class="overflow-x-auto"></div>
                <div class="overflow-x-auto"></div>
                <div class="overflow-x-auto"></div>
            </section>
        </div>
    @endsection
</x-app-layout>
