<x-guest-layout>

    @section('form')
        <div class="bg-[#0A2827] flex flex-col h-auto p-3 w-full lg:w-[50%] lg:h-full xl:w-[30%] justify-center items-center">
            <div class="flex w-full min-h-[40%] p-5 sm:w-[75%] sm:p-0 lg:w-[90%]">
                <form method="POST" class="w-full  p-3 flex flex-col justify-center items-center"
                    action="{{ route('register') }} ">
                    @csrf
                    <h2 class="text-white text-2xl xl:text-4xl mb-4">Ingresa tus datos</h2>
                    <!-- Name -->
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    <div class="flex justify-center items-center w-full mb-1 xl:mb-2">
                        <x-input-label for="name" />
                        <x-text-input id="name" class=" mt-1 justify-center" type="text" name="name"
                            required autofocus autocomplete="name" placeholder="Nombre" />
                    </div>

                    <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
                    <!-- Lastname -->
                    <div class="flex justify-center items-center w-full mb-1 xl:mb-2">
                        <x-input-label for="lastname" />
                        <x-text-input id="lastname" class=" mt-1 justify-center" type="text" name="lastname"
                            required autofocus autocomplete="lastname" placeholder="Apellidos" />
                    </div>

                    <!-- Email Address -->
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-center" />
                    <div class="flex justify-center items-venter w-full mb-1 xl:mb-2">
                        <x-input-label for="email" />
                        <x-text-input id="email" class=" mt-1  justify-center" type="email" name="email"
                            required autofocus autocomplete="username" placeholder="Email" />
                    </div>

                    <!-- phone -->
                    <x-input-error :messages="$errors->get('phone')" class="mt-2 text-center" />
                    <div class="flex justify-center items-venter w-full mb-1 xl:mb-2">
                        <x-input-label for="phone" />
                        <x-text-input id="phone" class=" mt-1 justify-center" type="number" name="phone"
                            required autocomplete="phone" placeholder="Teléfono" />
                    </div>

                    <!-- Password -->
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    <div class="flex justify-center items-center w-full mb-1 xl:mb-2">
                        <x-input-label for="password" />
                        <x-text-input id="password" class=" mt-1 justify-center" type="password" name="password"
                            required autocomplete="new-password" placeholder="Contraseña" />
                    </div>

                    <!-- Confirm Password -->
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    <div class="flex justify-center items-center w-full mb-1 xl:mb-2">
                        <x-input-label for="password_confirmation" />
                        <x-text-input id="password_confirmation" class=" mt-1 justify-center" type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Corfima tu contraseña" />
                    </div>


                    <div class="flex justify-end items-center w-full">
                        <a class=" text-sm text-white
                        hover:text-white/80 cursor-pointer"
                            href="{{ route('login') }}">
                            {{ __('¿Ya estás resgistrado?  Inicia sesión') }}
                        </a>
                    </div>
                    <x-primary-button class="h-14 justify-center items-center mt-6 xl:mt-10">
                        {{ __('Registrarse') }}
                    </x-primary-button>
            </div>
            </form>
        </div>
        </div>
    @endsection


</x-guest-layout>
