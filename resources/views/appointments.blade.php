<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Citas medicas</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <x-header />
    <main>
        <h1>Citas medicas</h1>
        <section class="appointment-form">
            <h1>Crear cita</h1>
            <form method="POST" action="/appointments">
                @csrf <!-- Token automatico-->
                <div class="field">
                    <label for="user_id">ID del paciente</label>
                    <input type="text" name="user_id" required />
                </div>
                <div class="field">
                    <label for="reason">Motivo de consulta</label>
                    <textarea name="reason" required></textarea>
                </div>
                <div class="field">
                    <label for="date">Fecha</label>
                    <input type="datetime-local" name="date" required />
                </div>

                <button type="submit">Agendar cita</button>
            </form>
        </section>
        <section class="appointment-list">
            <h1>Listado de citas medicas</h1>
            @forelse ($appointments as $appointment)
                <article class="appointment">
                    <h3>Nombre del paciente: {{ $appointment->user->name }}</h3>
                    <p>
                        <strong>Correo electronico:</strong>
                        {{ $appointment->user->email }}
                    </p>
                    <p>
                        <strong>Motivo:</strong>
                        {{ $appointment->reason }}
                    </p>

                    <p>
                        <strong>Fecha:</strong>
                        {{ $appointment->date }}
                    </p>
                    <a href="/appointments/{{ $appointment->id }}/edit" class="button">
                        Editar
                    </a>

                    <form metho="POST">
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Seguro que desea eliminar esta cita?')"
                            class="btn-delete">
                            Eliminar
                        </button>
                    </form>
                </article>
            @empty
                <div class="empty">
                    No hay citas agendadas.
                </div>
            @endforelse
        </section>
    </main>
</body>

</html>