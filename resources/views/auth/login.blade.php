<x-guest-layout>
    @section('title', 'Inicio de sesión')

    @section('form')
        <div class="bg-[#0A2827] flex flex-col h-auto p-3 w-full md:h-full lg:w-[50%] xl:h-full xl:w-[30%] justify-center items-center">
            <div class="flex w-full min-h-[40%] sm:w-[75%] lg:w-[90%]">
                <!-- Session Status -->
                <form method="POST" action="{{ route('login') }} " class="w-full p-3 flex flex-col justify-center items-center">
                    @csrf
                    <h2 class="text-white text-2xl font-bold xl:text-4xl mb-8">Inicio de sesión</h2>

                    <!-- Email Address -->
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    <div class="flex justify-center items-center w-full mb-1 xl:mb-4">
                        <x-input-label for="email" />
                        <x-text-input id="email" class=" mt-1 justify-center" type="email" name="email" value="{{ old('email') }}"
                            autofocus autocomplete="email" placeholder="Email" />
                    </div>
                    <!-- Password -->
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-center" />
                    <div class="relative w-full mb-3">
                        <x-input-label for="password" />
                        <x-text-input id="password" class="w-full" type="password" name="password"
                            autocomplete="current-password" placeholder="Contraseña" />
                        <span class="absolute right-2.5 top-[25%] translate-y-[50%]  cursor-pointer"
                            onclick="togglePassword()">
                            <img src="{{ asset('icons/toggle-password.png') }}" alt="Mostrar/ocultar contraseña"
                                id="toggle-icon">
                        </span>
                    </div>

                    <!-- Enlaces -->
                    <div class="flex w-full justify-around ">
                        <div class="flex w-[50%] justify-start items-center">
                            @if (Route::has('password.request'))
                                <a class=" text-xs xl:ml-4 text-white hover:text-white/80  cursor-pointer underline"
                                    href="{{ route('register') }}">
                                    {{ __('¿Aún no estas registrado?') }}
                                </a>
                            @endif
                        </div>
                        <div class="flex w-[50%] h-full justify-end items-center">
                            @if (Route::has('password.request'))
                                <a class=" text-xs xl:mr-4 text-white hover:text-white/80 cursor-pointer underline"
                                    href="{{ route('password.request') }}">
                                    {{ __('Olvidé mi contraseña') }}
                                </a>
                            @endif
                        </div>
                    </div>
                    <x-primary-button class="h-14 w-full mt-4 xl:mt-10">
                        {{ __('Iniciar sesión') }}
                    </x-primary-button>
            </div>
            </form>
        </div>
        </div>
        <script>
            // Función para mostrar/ocultar contraseña
            function togglePassword() {
                var password = document.getElementById('password');
                var icon = document.getElementById('toggle-icon');

                if (password.type === 'password') {
                    password.type = 'text';
                    icon.src = '{{ asset('icons/toggle-password-off.png') }}';
                } else {
                    password.type = 'password';
                    icon.src = '{{ asset('icons/toggle-password.png') }}';
                }
            }
        </script>
    @endsection
</x-guest-layout>
