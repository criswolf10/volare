<x-app-layouts>
    @section('title', 'Vuelos')
    @section('title-page', 'Editar vuelo')

    @section('content')
        <div class="p-5">
            <form action="{{ route('flights.update', $flight->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="code">Código</label>
                        <input type="text" name="code" id="code" value="{{ $flight->code }}" class="form-input">
                    </div>
                    <div>
                        <label for="aircraft">Avión</label>
                        <input type="text" name="aircraft" id="aircraft" value="{{ $flight->aircraft }}" class="form-input">
                    </div>
                    <div>
                        <label for="origin">Origen</label>
                        <input type="text" name="origin" id="origin" value="{{ $flight->origin }}" class="form-input">
                    </div>
                    <div>
                        <label for="destination">Destino</label>
                        <input type="text" name="destination" id="destination" value="{{ $flight->destination }}" class="form-input">
                    </div>
                    <div>
                        <label for="duration">Duración</label>
                        <input type="text" name="duration" id="duration" value="{{ $flight->duration }}" class="form-input">
                    </div>
                    <div>
                        <label for="departure_date">Fecha de salida</label>
                        <input type="date" name="departure_date" id="departure_date" value="{{ $flight->departure_date }}" class="form-input">
                    </div>
                    <div>
                        <label for="seats_class">Clase de asientos</label>
                        <input type="text" name="seats_class" id="seats_class" value="{{ $flight->seats_class }}" class="form-input
</x-app-layouts>
