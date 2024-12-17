<section>
    <div class="bg-white shadow-lg rounded-lg p-5">
        <h2 class="text-lg xl:text-3xl font-semibold text-gray-900">
            {{ __('Introduce los datos del nuevo usuario') }}
        </h2>

        <form method="post" action="{{ route('user-create') }}" class="mt-4">
            @csrf
            @method('patch')

            <!-- Grid Container -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <!-- Name -->
                <div>
                    <x-input-label for="name" />
                    <x-text-input id="name" class="mt-1 w-full" type="text" name="name" placeholder="Nombre"
                        value="{{ old('name') }}" autofocus autocomplete="given-name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Lastname -->
                <div>
                    <x-input-label for="lastname" />
                    <x-text-input id="lastname" class="mt-1 w-full" type="text" name="lastname" placeholder="Apellidos"
                        value="{{ old('lastname') }}" autofocus autocomplete="family-name" />
                    <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" />
                    <x-text-input id="email" class="mt-1 w-full" type="email" name="email" placeholder="Email"
                        value="{{ old('email') }}" autofocus autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Phone -->
                <div>
                    <x-input-label for="phone" />
                    <x-text-input id="phone" class="mt-1 w-full" type="tel" name="phone" placeholder="Teléfono"
                        value="{{ old('phone') }}" autocomplete="tel" pattern="\d{9}" maxlength="9" inputmode="numeric" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="relative">
                    <x-input-label for="password" />
                    <x-text-input id="password" class="mt-1 w-full" type="password" name="password" placeholder="Contraseña"
                        autocomplete="current-password" />
                    <span class="absolute right-3 top-[50%] translate-y-[-50%] cursor-pointer" onclick="togglePassword()">
                        <img src="{{ asset('icons/toggle-password.png') }}" alt="Mostrar/ocultar contraseña" id="toggle-icon">
                    </span>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" />
                    <x-text-input id="password_confirmation" class="mt-1 w-full" type="password"
                        name="password_confirmation" placeholder="Confirmar contraseña" autocomplete="new-password" />
                </div>

                <!-- Role -->
                <div>
                    <x-input-label for="role" :value="__('Role')" />
                    <select name="role" id="role" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-300">
                        <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col md:flex-row gap-4 mt-6">
                <x-tertiary-button>
                    {{ __('Crear usuario') }}
                </x-tertiary-button>
                <x-danger-button>
                    <a href="{{ route('users') }}">{{ __('Cancelar') }}</a>
                </x-danger-button>
            </div>
        </form>
    </div>

    <script>
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
</section>
