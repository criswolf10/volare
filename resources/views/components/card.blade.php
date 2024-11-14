<div class="">
    <div class="">

        <!-- Título -->
        <div class="flex justify-center items-center w-full h-full bg-white">
            <h3 class="text-2xl font-semibold m-6 uppercase">{{ $title }}</h3>
        </div>

        <!-- Imagen -->
        <div class="">
            <img src="{{ asset($image) }}" alt="{{ $title }}" class="">
        </div>

        <!-- Descripción y Botón -->
        <div class="">
            <p class="">{{ $slot }}</p>
            <x-primary-button>
                <a href="{{ auth()->check() ? route('sales') : route('login') }}">
                    {{ __('Reservar') }}
                </a>
            </x-primary-button>
        </div>

    </div>
</div>
