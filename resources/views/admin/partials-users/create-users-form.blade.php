<section>
    <div class="flex flex-col justify-start bg-white shadow-lg rounded-lg p-5 gap-2">
        <h2 class="text-lg xl:text-3xl font-semibold text-gray-900">
            {{ __('Introduce los datos del nuevo usuario') }}
        </h2>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('user-create') }}" class="mt-4">
            @csrf
            @method('patch')


            <!-- Name -->
            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="name" />
                <x-text-input id="name" class=" mt-1 justify-center" type="text" name="name"
                    value="{{ old('name') }}" required autofocus autocomplete="given-name" placeholder="Nombre" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />

            <!-- Lastname -->
            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="lastname" />
                <x-text-input id="lastname" class=" mt-1 justify-center" type="text" name="lastname"
                    value="{{ old('lastname') }}" required autofocus autocomplete="family-name"
                    placeholder="Apellidos" />
            </div>
            <x-input-error :messages="$errors->get('lastname')" class="mt-2" />

            <!-- Email Address -->
            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="email" />
                <x-text-input id="email" class=" mt-1  justify-center" type="email" name="email"
                    value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="Email" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-center" />

            <!-- phone -->
            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="phone" />
                <x-text-input id="phone" class=" mt-1 justify-center" type="tel" name="phone"
                    value="{{ old('phone') }}" required autocomplete="tel" pattern="\d{9}" maxlength="9"
                    inputmode="numeric" placeholder="Teléfono" />
            </div>
            <x-input-error :messages="$errors->get('phone')" class="mt-2 text-center" />


            <!-- Password -->
            <div class="relative mb-3 xl:w-[50%]">
                <x-input-label for="password" />
                <x-text-input id="password" class="w-full mt-1" type="password" name="password" required
                    autocomplete="current-password" placeholder="Contraseña" />
                <span class="absolute right-2.5 top-[25%] translate-y-[50%]  cursor-pointer" onclick="togglePassword()">
                    <img src="{{ asset('icons/toggle-password.png') }}" alt="Mostrar/ocultar contraseña"
                        id="toggle-icon">
                </span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-center" />


            <!-- Confirm Password -->
            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="password_confirmation" />
                <x-text-input id="password_confirmation" class=" mt-1 justify-center" type="password"
                    name="password_confirmation" required autocomplete="new-password"
                    placeholder="Confimar contraseña" />
            </div>

            <!-- Role -->
            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="role" :value="__('Role')" />
                <select name="role" id="role" class="mt-1 block w-full">
                    <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            <div class="flex items-center gap-4 mb-3 xl:w-[50%]">
                <x-tertiary-button>
                    {{ __('Crear usuario') }}
                </x-tertiary-button>
                <x-danger-button>
                    <a href="{{ route('users') }}">{{ __('Cancelar') }}</a>
                </x-danger-button>
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
</section>
