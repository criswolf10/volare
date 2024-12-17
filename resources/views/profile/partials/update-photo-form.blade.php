<div class="flex flex-col justify-start bg-white shadow-lg rounded-lg p-5 gap-2">
    <h2 class="text-xl xl:text-3xl font-semibold text-gray-900">
        {{ __('Profile Photo') }}
    </h2>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    <!-- Formulario de actualización de foto de perfil -->
    <form method="POST" action="{{ route('profile.update-photo', ['user' => $user->id]) }}" enctype="multipart/form-data"
        class="mb-4">
        @csrf
        @method('PUT')
        <div class="flex flex-col justify-start xl:flex-row xl:items-center xl:gap-7">
            <!-- Mostrar la foto de perfil actual -->
            <div class="mb-4">
                <img src="{{ $user->getFirstMediaUrl('profile_photos') ?: asset('img/avatar.png') }}"
                    alt="Foto de perfil" class="w-24 h-24 xl:w-32 xl:h-32 rounded-full object-cover">
            </div>

            <!-- Campo para subir nueva foto -->
            <div class="flex flex-col">
                <label for="profile_photo" class="block text-sm font-semibold text-gray-700">Actualiza tu foto de
                    perfil</label>
                <input type="file" name="profile_photo" id="profile_photo" class="mt-2 text-gray-700">
            </div>
        </div>
        <div class="flex items-center gap-4 xl:w-[25%]">
            <x-tertiary-button>{{ __('Actualizar foto') }}</x-tertiary-button>
        </div>
    </form>
    <!-- Enlace para eliminar la foto de perfil -->
    <form method="POST" action="{{ route('profile.delete-photo', ['user' => $user->id]) }}">
        @csrf
        @method('DELETE')
        <div class="flex flex-col items-center xl:w-[25%]">
            <p class="text-sm lg:text-lg text-gray-700 font-semibold">{{ __('¿Quieres eliminar tu foto de perfil?') }}</p>
            <x-danger-button>{{ __('Eliminar foto') }}</x-danger-button>
        </div>
    </form>
</div>
