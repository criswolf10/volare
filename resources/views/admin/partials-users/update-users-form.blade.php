<section>
    <div class="bg-white shadow-lg rounded-lg p-5">
        <h2 class="text-lg xl:text-3xl font-semibold text-gray-900">
            {{ __('User profile') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 font-semibold">
            {{ __('Update the user personal data') }}
        </p>

        <!-- Verification Form -->
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <!-- Profile Update Form -->
        <form method="POST" action="{{ route('user-update', ['id' => $user->id]) }}" class="mt-4">
            @csrf
            @method('PATCH')

            <!-- Grid Container -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 w-full"
                        :value="old('name', $user->name)" autofocus autocomplete="given-name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Lastname -->
                <div>
                    <x-input-label for="lastname" :value="__('Lastname')" />
                    <x-text-input id="lastname" name="lastname" type="text" class="mt-1 w-full"
                        :value="old('lastname', $user->lastname)" autofocus autocomplete="family-name" />
                    <x-input-error class="mt-2" :messages="$errors->get('lastname')" />
                </div>

                <!-- Phone -->
                <div>
                    <x-input-label for="phone" :value="__('Phone')" />
                    <x-text-input id="phone" name="phone" type="tel" class="mt-1 w-full"
                        :value="old('phone', $user->phone)" autofocus autocomplete="tel" maxlength="9" inputmode="numeric" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 w-full"
                        :value="old('email', $user->email)" autocomplete="email" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>
            </div>

            <!-- Email Verification -->
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-4">
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900">
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

            <!-- Password Update -->
            <p class="mt-10 text-sm text-gray-600 font-semibold">
                {{ __('Update the password *this step is optional* ') }}
            </p>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mt-2">
                <!-- Current Password -->
                <div>
                    <x-input-label for="current_password" :value="__('Current Password')" />
                    <x-text-input id="current_password" name="current_password" type="password"
                        class="mt-1 w-full" autocomplete="current-password" />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <!-- New Password -->
                <div>
                    <x-input-label for="password" :value="__('New Password')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 w-full"
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                        class="mt-1 w-full" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <!-- Role Selection -->
            <div class="mt-4">
                <x-input-label for="role" :value="__('Role')" />
                <select name="role" id="role" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring">
                    <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <!-- Buttons -->
            <div class="flex justify-center items-center gap-4 mt-6">
                <x-tertiary-button>{{ __('Save') }}</x-tertiary-button>
                <x-danger-button>
                    <a href="{{ route('users') }}">{{ __('Cancelar') }}</a>
                </x-danger-button>
            </div>
        </form>
    </div>
</section>

<!-- User Deletion Section -->
<section class="space-y-6 mt-6">
    <div class="bg-white shadow-lg rounded-lg p-5">
        <h2 class="text-lg xl:text-2xl font-medium text-gray-900">
            {{ __('Delete user') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.') }}
        </p>
        <x-danger-button class="mt-4" x-data="{}" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            {{ __('Delete Account') }}
        </x-danger-button>

        <!-- Confirmation Modal -->
        <x-modal name="confirm-user-deletion" focusable>
            <form method="POST" action="{{ route('user-delete', ['id' => $user->id]) }}" class="p-6">
                @csrf
                @method('DELETE')

                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Are you sure you want to delete this user :user?', ['user' => $user->name]) }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Please enter your password to confirm this action.') }}
                </p>

                <!-- Password Input -->
                <div class="mt-4">
                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('Password') }}" />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-danger-button>
                        {{ __('Delete Account') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    </div>
