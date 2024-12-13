<section>
    <div class="flex flex-col justify-start bg-white shadow-lg rounded-lg p-5 gap-2">
        <h2 class="text-lg xl:text-3xl font-semibold text-gray-900">
            {{ __('User profile') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 font-semibold">
            {{ __('Update the user personal data') }}
        </p>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="POST" action="{{ route('user-update', ['id' => $user->id]) }}" class="mt-4">
            @csrf
            @method('PATCH')


            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                    autofocus autocomplete="given-name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="lastname" :value="__('Lastname')" />
                <x-text-input id="lastname" name="lastname" type="text" class="mt-1 block w-full" :value="old('lastname', $user->lastname)"
                    autofocus autocomplete="family-name" />
                <x-input-error class="mt-2" :messages="$errors->get('lastname')" />
            </div>
            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $user->phone)"
                    autofocus autocomplete="tel" inputmode="numeric" maxlength="9" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                    autocomplete="email" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-center" />
            <p class="mt-10 mb-2 text-sm text-gray-600 font-semibold">
                {{ __('Update the password *this step is optional* ') }}
            </p>
            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="update_password_current_password" :value="__('Current Password')" />
                <x-text-input id="update_password_current_password" name="current_password" type="password"
                    class="mt-1 block w-full" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>
            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="update_password_password" :value="__('New Password')" />
                <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full"
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div class="mb-3 xl:w-[50%]">
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                    class="mt-1 block w-full" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
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

            <div class="flex justify-center items-center gap-4 mb-3 xl:w-[50%]">
                <x-tertiary-button>{{ __('Save') }}</x-tertiary-button>

                <x-danger-button>
                    <a href="{{ route('users') }}">{{ __('Cancelar') }}</a>
                </x-danger-button>
            </div>

        </form>
    </div>

</section>

{{-- Sección de Eliminación --}}
<section class="space-y-6 mt-5">

    <div class="flex flex-col justify-start bg-white shadow-lg rounded-lg p-5 gap-2" x-data="{ modalOpen: false }">
        <h2 class="text-lg xl:text-2xl font-medium text-gray-900">
            {{ __('Delete user') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 xl:w-[50%] font-semibold">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.') }}
        </p>

        {{-- Botón de eliminar usuario --}}
        <x-danger-button class="xl:w-[25%]" x-on:click.prevent="$dispatch('open-modal', 'user-deletion')">
            {{ __('Delete Account') }}
        </x-danger-button>

        <!-- Modal de Confirmación de Eliminación -->
        <x-modal name="user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="POST" action="{{ route('user-delete', ['id' => $user->id]) }}" class="p-6">
                @csrf
                @method('DELETE')

                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Are you sure you want to delete this user :user?', ['user' => $user->name]) }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __('If you are sure, enter the password of your administrator account to confirm it.') }}
                </p>

                {{-- Campo de Contraseña --}}
                <div class="mt-6">
                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('Password') }}" />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                {{-- Botón de Confirmar Eliminación --}}
                <div class="mt-6 flex justify-center">
                    <x-danger-button>
                        {{ __('Delete user') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>

    </div>
</section>
