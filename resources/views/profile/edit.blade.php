<x-app-layout>
    @section('title', 'Editar Perfil')
    @section('content')

<div>

                    <div class="">
                    @include('profile.partials.update-photo')
                    </div>



                    <div class="">
                        @include('profile.partials.update-profile-information-form')
                    </div>



                    <div class="">
                        @include('profile.partials.update-password-form')
                    </div>


                    <div class="">
                        @include('profile.partials.delete-user-form')
                    </div>
            </div>
        </div>
    @endsection
</x-app-layout>
