<div class="relative w-full h-[500px] overflow-hidden rounded-lg shadow-lg group">
    <!-- Contenedor del slider -->
    <div class="flex transition-transform duration-500 ease-in-out w-full h-full" data-slider>
        @foreach ($slides as $slide)
            <div class="w-full flex-shrink-0 flex flex-col justify-center items-center text-white relative">
                <!-- Imagen de fondo -->
                <div class="absolute inset-0 w-full h-full">
                    <img src="{{ asset($slide['image']) }}" alt="{{ $slide['title'] }}" class="w-full h-full object-cover">
                </div>

                <!-- Fondo semitransparente encima de la imagen -->
                <div class="absolute inset-0 bg-black bg-opacity-50"></div>

                <!-- Contenido del banner -->
                <div class="relative z-10 text-center p-6">
                    <!-- Título -->
                    <h3 class="text-4xl font-bold mb-4">{{ $slide['title'] }}</h3>
                    <!-- Descripción -->
                    <p class="text-lg mb-6">{{ $slide['description'] }}</p>
                    <!-- Botón -->
                    <a
                        href="{{ $slide['buttonUrl'] }}"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition">
                        {{ __('Reservar') }}
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Botones de control -->
    <button
        class="absolute left-3 top-1/2 transform -translate-y-1/2 bg-gray-700 bg-opacity-70 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition"
        data-prev>
        &#9664;
    </button>
    <button
        class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-gray-700 bg-opacity-70 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition"
        data-next>
        &#9654;
    </button>
</div>
