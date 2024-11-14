<!-- resources/views/index.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <title>Cargando...</title>
    @vite(['resources/css/index.css', 'resources/js/app.js'])

</head>
<body>
    <div class="bg-[#0A2827]">
        <img src="{{ asset('img/logo-index.png') }}" alt="Logo de la Empresa">
        <h2>Prepara las maletas...</h2>
    </div>

    <script>
        // Redirigir a la página de inicio después de 5 segundos
        setTimeout(() => {
            window.location.href = "{{ route('home') }}";
        }, 3500);
    </script>
</body>
</html>
