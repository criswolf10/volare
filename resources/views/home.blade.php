<x-app-layout>
    @section('title', 'Volare | Inicio')

    @section('title-page', '¿Cuál será tu próximo destino?')

    @section('content')
        <div class="flex flex-col min-h-screen justify-around p-7 gap-6 lg:flex-row xl:mt-4">
            <!-- Carta 1 -->
            <x-card title="Tailandia" image="img/tailandia.jpg">
                Explora el encanto de este destino con paisajes impresionantes y cultura vibrante.
            </x-card>

            <!-- Carta 2 -->
            <x-card title="Atenas" image="img/grecia.jpg">
                Un lugar lleno de historia y belleza natural, ideal para una escapada relajante.
            </x-card>

            <!-- Carta 3 -->
            <x-card title="Estambul" image="img/estambul.jpg">
                Descubre los sabores y tradiciones de este destino único en el mundo.
            </x-card>

        </div>
    @endsection
</x-app-layout>
