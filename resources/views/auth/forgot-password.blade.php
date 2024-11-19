<x-guest-layout>
    @section('form')
    <div class="bg-[#0A2827] flex flex-col h-auto p-3 w-full md:h-full lg:w-[50%] xl:h-full xl:w-[30%] justify-center items-center">
        <div class="flex w-full min-h-[40%] sm:w-[75%] lg:w-[90%]">

                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('password.email') }}"
                    class="w-full flex flex-col justify-center items-center">
                    @csrf
                    <h2 class="text-white text-center text-2xl xl:text-3xl mb-4 ">¿Olvidaste tu contraseña? </h2>
                    <div class="flex w-[75%] text-1xl text-white mb-4 text-center">
                        {{ __('No te preocupes. Ingresa tu dirección de correo electrónico y te enviaremos un enlace para restablecerla.') }}
                    </div>
                    <!-- Email Address -->

                    <div class="flex justify-center items-venter w-full mb-3">
                        <x-input-label for="email" />
                        <x-text-input id="email" type="email" name="email" required autofocus
                            autocomplete="username" placeholder="Email" />
                    </div>
                    <x-primary-button>
                        {{ __('Recuperar Contraseña') }}
                    </x-primary-button>
                    <div class="flex items-center justify-end mt-3 w-full">
                        <a class="text-sm xl:mr-4 text-white hover:text-white/80  cursor-pointer underline" href="{{ route('login') }}">
                            {{ __('¿La has recordado? Vuelve a iniciar sesion') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    @endsection
</x-guest-layout>
