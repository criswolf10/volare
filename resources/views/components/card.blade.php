<div class="flex flex-col justify-center items-center h-full bg-[#E4F2F2] p-5 shadow-lg rounded-lg w-full">
    <div class="flex flex-col w-full h-full bg-white shadow-lg rounded-lg p-3 gap-6 ">

        <!-- Título -->
        <div class="flex justify-center items-center w-full  bg-white">
            <h3 class="text-2xl font-semibold uppercase">{{ $title }}</h3>
        </div>

        <!-- Imagen -->
        <div class="flex justify-center items-center w-full p-2 bg-white">
            <img src="{{ asset($image) }}" alt="{{ $title }}" class="w-full h-48 object-cover rounded-lg">
        </div>

        <!-- Descripción y Botón -->
        <div class="flex flex-col justify-center items-center w-full bg-white ">
            <p class="text-gray-600 text-center">{{ $slot }}</p>
            <x-tertiary-button class="mt-12 w-full">
                <a href="{{ auth()->check() ? route('flights') : route('login') }}">
                    {{ __('Reservar') }}
                </a>
            </x-tertiary-button>
        </div>

    </div>
</div>
