<x-guest-layout>
    @section('title', 'Registro')

    @section('form')
    <!-- Verificar si hay un mensaje de éxito en la sesión y mostrar el modal -->
    @if(session('success'))
    <x-modal-success show="true" name="success-modal" />
@endif
        <div
            class="bg-[#0A2827] flex flex-col h-auto p-3 w-full lg:w-[50%] lg:h-full xl:w-[30%] justify-center items-center">
            <div class="flex w-full min-h-[40%] p-5 sm:w-[75%] sm:p-0 lg:w-[90%]">
                <form method="POST" class="w-full  p-3 flex flex-col justify-center items-center"
                    action="{{ route('register') }} ">
                    @csrf
                    <h2 class="text-white font-bold text-2xl xl:text-4xl mb-4">Ingresa tus datos</h2>

                    <!-- Name -->
                    <div class="flex justify-center items-center w-full mb-1 xl:mb-2">
                        <x-input-label for="name" />
                        <x-text-input id="name" class=" mt-1 justify-center" type="text" name="name"
                            value="{{ old('name') }}" required autofocus autocomplete="given-name" placeholder="Nombre" />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />

                    <!-- Lastname -->
                    <div class="flex justify-center items-center w-full mb-1 xl:mb-2">
                        <x-input-label for="lastname" />
                        <x-text-input id="lastname" class=" mt-1 justify-center" type="text" name="lastname"
                            value="{{ old('lastname') }}" required autofocus autocomplete="family-name"
                            placeholder="Apellidos" />
                    </div>
                    <x-input-error :messages="$errors->get('lastname')" class="mt-2" />

                    <!-- Email Address -->
                    <div class="flex justify-center items-venter w-full mb-1 xl:mb-2">
                        <x-input-label for="email" />
                        <x-text-input id="email" class=" mt-1  justify-center" type="email" name="email"
                            value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="Email" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-center" />

                    <!-- phone -->
                    <div class="flex justify-center items-venter w-full mb-1 xl:mb-2">
                        <x-input-label for="phone" />
                        <x-text-input id="phone" class=" mt-1 justify-center" type="tel" name="phone"
                            value="{{ old('phone') }}" required autocomplete="tel" pattern="\d{9}" maxlength="9" inputmode="numeric" placeholder="Teléfono" />
                    </div>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2 text-center" />

                    <!-- Password -->
                    <div class="relative w-full mb-1 xl:mb-2">
                        <x-input-label for="password" />
                        <x-text-input id="password" class="w-full mt-1" type="password" name="password" required
                            autocomplete="current-password" placeholder="Contraseña" />
                        <span class="absolute right-2.5 top-[25%] translate-y-[50%]  cursor-pointer"
                            onclick="togglePassword()">
                            <img src="{{ asset('icons/toggle-password.png') }}" alt="Mostrar/ocultar contraseña"
                                id="toggle-icon">
                        </span>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-center" />

                    <!-- Confirm Password -->
                    <div class="flex justify-center items-center w-full mb-1 xl:mb-2 ">
                        <x-input-label for="password_confirmation" />
                        <x-text-input id="password_confirmation" class=" mt-1 justify-center" type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Confima tu contraseña" />
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                    <div class="flex justify-end items-center w-full underline">
                        <a class=" text-sm text-white
                        hover:text-white/80 cursor-pointer"
                            href="{{ route('login') }}">
                            {{ __('¿Ya estás resgistrado?  Inicia sesión') }}
                        </a>
                    </div>
                    <x-primary-button class="h-14 justify-center items-center mt-6 xl:mt-10">
                        {{ __('Crear cuenta') }}
                    </x-primary-button>
            </div>
            </form>
        </div>
        </div>

        <script>
            // Función para mostrar/ocultar contraseñas
            function togglePassword() {
                var password = document.getElementById('password');
                var passwordConfirmation = document.getElementById('password_confirmation');
                var icon = document.getElementById('toggle-icon');

                // Alternar el tipo de ambos campos de contraseña
                if (password.type === 'password') {
                    password.type = 'text';
                    passwordConfirmation.type = 'text';
                    icon.src = '{{ asset('icons/toggle-password-off.png') }}'; // Cambiar ícono a "mostrar"
                } else {
                    password.type = 'password';
                    passwordConfirmation.type = 'password';
                    icon.src = '{{ asset('icons/toggle-password.png') }}'; // Cambiar ícono a "ocultar"
                }
            }
        </script>
    @endsection
</x-guest-layout>
