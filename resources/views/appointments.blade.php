<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Citas medicas</title>

    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>

<body>
    <div id="app">
        <x-header />
        <main>
            <h1>Citas medicas</h1>

            @if (session('succes') || session('success'))
                <flash-alert message="{{ session('succes') ?? session('success') }}" type="success"></flash-alert>
            @endif

            <section class="appointment-form">
                <h1>Crear cita</h1>
                <form method="POST" action="/appointments">
                    @csrf
                    <div class="field">
                        <label for="user_id">ID del paciente</label>
                        <input type="text" id="user_id" name="user_id" required />
                    </div>
                    <div class="field">
                        <label for="reason">Motivo de consulta</label>
                        <textarea id="reason" name="reason" required></textarea>
                    </div>
                    <div class="field">
                        <label for="date">Fecha</label>
                        <input type="datetime-local" id="date" name="date" required />
                    </div>

                    <button type="submit">Agendar cita</button>
                </form>
            </section>

            <appointments-list :initial-appointments='@json($appointments)' csrf-token="{{ csrf_token() }}"></appointments-list>
        </main>
    </div>
</body>

</html>