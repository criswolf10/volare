<x-app-layout>
    @section('title', 'Gestión de usuarios')

    @section('title-page', 'Crear usuario')

    @section('content')
    <div class="flex flex-col h-full w-full justify-around p-5 gap-6 shadow-lg rounded-lg">
        <div class="flex flex-col bg-[#E4F2F2] p-4 shadow-lg rounded-lg">
        @include('admin.partials-users.create-users-form')
        </div>
    </div>
    @endsection
</x-guest-layout>
