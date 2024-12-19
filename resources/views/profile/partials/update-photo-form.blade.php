<div class="flex flex-col h-full justify-start bg-white shadow-lg rounded-lg p-5 gap-2">
    <h2 class="text-xl md:text-2xl xl:text-3xl font-semibold text-gray-900">
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
        <div class="flex flex-col justify-center items-center ">
            <!-- Mostrar la foto de perfil actual -->
            <div class="mb-4 flex justify-start items-start w-full">
                <img src="{{ $user->getFirstMediaUrl('profile_photos') ?: asset('img/avatar.png') }}"
                    alt="Foto de perfil" class="w-24 h-24 md:w-32 md:h-32 xl:w-40 xl:h-40 rounded-full">
            </div>

            <!-- Campo para subir nueva foto -->
            <div class="flex flex-col w-full sm:w-3/4 md:w-2/3 lg:w-1/2 xl:w-full xl:justify-start items-start mt-4">
                <label for="profile_photo" class="text-sm font-semibold text-gray-700">Selecciona una foto</label>
                <input type="file" name="profile_photo" id="profile_photo" class="text-gray-700 mt-2">
            </div>
        </div>

        <div class="flex items-center gap-4 justify-end mt-20">
            <x-tertiary-button>{{ __('Actualizar foto') }}</x-tertiary-button>
        </div>
    </form>

    <!-- Enlace para eliminar la foto de perfil -->
    <form method="POST" action="{{ route('profile.delete-photo', ['user' => $user->id]) }}">
        @csrf
        @method('DELETE')
        <div class="flex flex-col justify-end items-center">
            <p class="mb-2 text-sm text-gray-700 font-semibold">{{ __('¿Quieres eliminar tu foto de perfil?') }}</p>
            <x-danger-button>{{ __('Eliminar foto') }}</x-danger-button>
        </div>
    </form>
</div>
