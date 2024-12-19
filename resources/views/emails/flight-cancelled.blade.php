<!DOCTYPE html>
<html>
<head>
    <title>Vuelo Cancelado</title>
</head>
<body>
    <h1>Lo sentimos, pero su vuelo ha sido cancelado</h1>

    @foreach($flight->tickets as $ticket)
        @if($ticket->user) <!-- Verificar si el ticket tiene un usuario asociado -->
            <p>Estimado/a {{ $ticket->user->name }},</p>
            <p>Lamentamos informarle que su vuelo {{ $flight->code }} desde {{ $flight->origin }} hasta {{ $flight->destination }} ha sido cancelado.</p>
            <p>Le pedimos disculpas por los inconvenientes y nos pondremos en contacto con usted para brindarle más información sobre sus opciones.</p>
            <p>Gracias por su comprensión.</p>
        @else
            <p>Lo sentimos, pero no se ha podido identificar al usuario asociado con este vuelo.</p>
        @endif
    @endforeach

</body>
</html>
