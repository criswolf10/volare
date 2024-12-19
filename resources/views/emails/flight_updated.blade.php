<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambio de Vuelo</title>
</head>
<body>
    <h1>Estimado/a {{ $user->name }}</h1>
    <p>Le informamos que tu vuelo con código {{ $flight->code }} ha sido actualizado. Los nuevos detalles son los siguientes:</p>

    <p><strong>Fecha de salida:</strong> {{ \Carbon\Carbon::parse($flight->departure_date)->format('d/m/Y') }}</p>
    <p><strong>Hora de salida:</strong> {{ \Carbon\Carbon::parse($flight->departure_time)->format('H:i') }}</p>
    <p><strong>Hora de llegada:</strong> {{ \Carbon\Carbon::parse($flight->arrival_time)->format('H:i') }}</p>

    <p>Te recomendamos que verifiques tus tickets y cualquier otro detalle relevante. Si tienes preguntas, no dudes en contactarnos.</p>

    <p>Saludos,</p>
    <p>El equipo de volare</p>
</body>
</html>
