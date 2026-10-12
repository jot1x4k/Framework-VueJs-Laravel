<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editar Cita Medica</title>

    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>

<body>
    <div id="app">
        <x-header />
        <main>
            <h1>Citas medicas</h1>
            <section class="appointment-form">
                <h1>Editar cita</h1>
                <form method="POST" action="/appointments/{{ $appointment->id }}">
                    @csrf
                    @method('PUT')
                    <div class="field">
                        <label for="reason">Motivo de consulta</label>
                        <textarea id="reason" name="reason" placeholder="{{ $appointment->reason }}">{{ $appointment->reason }}</textarea>
                    </div>
                    <div class="field">
                        <label for="date">Fecha</label>
                        <input type="datetime-local" id="date" name="date" value="{{ $appointment->date }}" />
                    </div>

                    <div style="margin-top: 12px; display: flex; gap: 8px;">
                        <button type="submit">Editar cita</button>
                        <a href="{{ url('/appointments') }}" class="button" style="background-color: #64748b;">Cancelar</a>
                    </div>
                </form>
            </section>
        </main>
    </div>
</body>

</html>