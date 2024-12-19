<x-app-layout>
    @section('title', 'Volare | Inicio')

    @section('title-page', 'Bienvenido a Volare')

    @section('content')
        <div class="flex flex-col min-h-screen justify-around p-7 gap-6 xl:mt-4">
            <div>
                <!-- Componente Slider -->
                <x-slider :slides="[
                    [
                        'image' => 'img/grecia.jpg',
                        'title' => 'Atenas',
                        'description' =>
                            'Un lugar lleno de historia y belleza natural, ideal para una escapada relajante.',
                        'buttonUrl' => route('flights'),
                    ],
                    [
                        'image' => 'img/estambul.jpg',
                        'title' => 'Estambul',
                        'description' => 'Descubre los sabores y tradiciones de este destino único en el mundo.',
                        'buttonUrl' => route('flights'),
                    ],
                    [
                        'image' => 'img/tailandia.jpg',
                        'title' => 'Tailandia',
                        'description' =>
                            'Explora el encanto de este destino con paisajes impresionantes y cultura vibrante.',
                        'buttonUrl' => route('flights'),
                    ],
                ]" />
            </div>
            <div class="mt-6">
                <div class="flex justify-center items-center text-xl xl:text-3xl font-bold mb-4 uppercase">
                    <h3>
                        Destinos populares
                    </h3>
                </div>
                <div class="flex flex-col md:flex-col lg:flex-row  gap-6">

                    <!-- Carta 1 -->
                    <x-card title="Tailandia" image="img/tailandia.jpg" />

                    <!-- Carta 2 -->
                    <x-card title="Atenas" image="img/grecia.jpg" />

                    <!-- Carta 3 -->
                    <x-card title="Estambul" image="img/estambul.jpg" />

                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
