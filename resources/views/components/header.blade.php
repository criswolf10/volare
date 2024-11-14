<!-- Logo -->
<div class="flex p-5 justify-start items-center sm:ml-5">
    <a href="{{ route('home') }}">
        <img src="{{ asset('img/logo-index.png') }}" alt="App-Logo"
            class="w-10 h-10 md:w-12 md:h-12 lg:w-14 lg:h-14 xl:w-16 xl:h-16 ">
    </a>
</div>

<div class="flex justify-end items-center md:mr-8">
    @auth
        <!-- Foto de perfil y nombre del usuario -->
        <div class="flex  justify-center items-center mr-4 w-7 h-7 md:mr-4 xl:mr-8 md:w-9 md:h-9 bg-[#EBFDFD] rounded">
            <img src="{{ asset('icons/search.png') }}" alt="Icono lupa" class="w-5 h-5 md:w-7 md:h-7 ">
        </div>
        <div class="flex justify-center items-center mr-2">
            <img src="{{ auth()->user()->getFirstMediaUrl('profile_photos') ?? asset('img/avatar.png') }}"
                alt="Foto de perfil" class="w-10 h-10 rounded-full object-cover mr-2 md:w-12 md:h-12 ">
            <div class="text-white text-sm uppercase md:text-lg ">{{ Auth::user()->name }}</div>
            <div  class="flex justify-center items-center">
                <!-- Icono como enlace de dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex justify-center items-center w-full">
                            <img src="{{ asset('icons/arrow.png') }}" alt="Icono flecha" class="w-6 h-5 ">
                        </button>
                    </x-slot>

                    <!-- Contenido del dropdown -->
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    @else
        <div class="flex justify-end items-center">
            <div class="flex justify-end items-center">
                <a href="{{ route('register') }}"
                    class="text-white text-sm mr-3 md:text-lg lg:text-lg ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    Registrarse
                </a>
            </div>
            @if (Route::has('login'))
                <div class="flex items-center justify-center mr-3 mb-3 ">
                    <x-primary-button onclick="window.location.href='{{ route('login') }}'">
                        Iniciar sesión
                    </x-primary-button>
                </div>
        </div>
        @endif
    @endauth
</div>
