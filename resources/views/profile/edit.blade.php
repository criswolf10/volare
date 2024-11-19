<x-app-layout>
    @section('title', 'Perfil')

    @section('title-page', 'Editar Perfil')

    @section('content')
        <div class="flex flex-col h-full w-full justify-around p-5 gap-6 shadow-lg rounded-lg">

            <div class="flex flex-col bg-[#E4F2F2] p-4 shadow-lg rounded-lg">
                @include('profile.partials.update-photo-form')
            </div>

            <div class="flex flex-col bg-[#E4F2F2] p-4 shadow-lg rounded-lg">
                @include('profile.partials.update-profile-information-form')

                <div class="flex flex-col bg-[#E4F2F2] p-4 shadow-lg rounded-lg">
                    @include('profile.partials.update-password-form')
                </div>

                <div class="flex flex-col bg-[#E4F2F2] p-4 shadow-lg rounded-lg">
                    @include('profile.partials.delete-user-form')
                </div>

            </div>

        </div>
    @endsection
</x-app-layout>
