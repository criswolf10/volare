<header class="flex">
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Profile Photo') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        {{ __("Update your photo's profile") }}
    </p>
</header>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>
<!-- Formulario de actualización de foto de perfil -->
<form method="POST" action="{{ route('profile.update-photo', ['user' => $user->id]) }}" enctype="multipart/form-data" class="mb-4">
    @csrf
    @method('PUT')
    <div class="flex items-center space-x-4">
        <!-- Mostrar la foto de perfil actual -->
        <div>
            <img src="{{ $user->getFirstMediaUrl('profile_photos') ?: asset('img/avatar.png') }}" alt="Foto de perfil"
                class="w-20 h-20 rounded-full object-cover">
        </div>

        <!-- Campo para subir nueva foto -->
        <div>
            <label for="profile_photo" class="block text-sm font-medium text-gray-700">Actualizar foto de perfil</label>
            <input type="file" name="profile_photo" id="profile_photo" class="mt-2 text-gray-700">
        </div>
    </div>
    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Update Photo') }}</x-primary-button>

        @if (session('status') === 'photo-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
        @endif
    </div>
</form>
