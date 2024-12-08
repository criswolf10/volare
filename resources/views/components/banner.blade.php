@props([
    'image' => '',
    'title' => '',
    'description' => '',
    'buttonUrl' => ''
])

<div class="relative w-full h-full bg-cover bg-center" style="background-image: url('{{ asset($image) }}'); opacity: 0.7;">
    <div class="absolute inset-0 flex flex-col justify-center items-center text-white p-5 bg-black bg-opacity-40">
        <h3 class="text-4xl font-bold mb-4">{{ $title }}</h3>
        <p class="text-lg text-center mb-6">{{ $description }}</p>
        <x-tertiary-button class="mt-12">
            <a href="{{ auth()->check() ? $buttonUrl : route('login') }}">
                {{ __('Reservar') }}
            </a>
        </x-tertiary-button>
    </div>
</div>
