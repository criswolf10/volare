<x-app-layout>
    @section('title', 'Vuelos')
    @section('title-page', 'Editar vuelo')

    @section('content')
    <div class="flex flex-col h-full w-full justify-around p-5 gap-6 shadow-lg rounded-lg">
        <div class="flex flex-col bg-[#E4F2F2] p-4 shadow-lg rounded-lg">
            @include('admin.partials-flights.update-flights-form')
        </div>
    </div>
    @endsection
    </x-app-layout>
