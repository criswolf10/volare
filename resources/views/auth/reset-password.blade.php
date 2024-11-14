<x-guest-layout>
    @section('form')

    <form method="POST" action="{{ route('password.store') }}" class="w-full flex flex-col justify-center items-center">
        @csrf
        <h2 class="text-white text-2xl mb-8 md:text-5xl md:mt-8 ">Cambiar contraseña </h2>
        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
        <div class="flex justify-center items-venter w-full mb-3">
            <x-input-label for="email" />
            <x-text-input id="email" class=" mt-1 w-3/4 justify-center" type="email" name="email" required autofocus
                autocomplete="username" placeholder="Email" />
        </div>

        <!-- Password -->
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <div class="flex justify-center items-center w-full mb-3">
                <x-input-label for="password"  />
                <x-text-input id="password" class=" mt-1 w-[75%] justify-center"
                                type="password"
                                name="password"
                                required autocomplete="new-password"
                                placeholder="Contraseña"/>
            </div>

        <!-- Confirm Password -->
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            <div class="flex justify-center items-center w-full mb-3">
                <x-input-label for="password_confirmation"  />

                <x-text-input id="password_confirmation" class=" mt-1 w-[75%] justify-center"
                                type="password"
                                name="password_confirmation"
                                required autocomplete="new-password"
                                placeholder="Corfima tu contraseña" />
            </div>

            <x-primary-button class="xl:mt-10">
                {{ __('Iniciar sesión') }}
            </x-primary-button>
    </form>
    @endsection
</x-guest-layout>
