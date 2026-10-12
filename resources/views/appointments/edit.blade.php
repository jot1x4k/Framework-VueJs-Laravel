<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Citas medicas</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<div>
    <section class="appointment-form">
        <h1>Editar cita</h1>
        <form method="POST" action="/appointments/{{ $appointment->id }}">
            @csrf <!-- Token automatico-->
            @method('PUT')
            <div class="field">
                <label for="reason">Motivo de consulta</label>
                <textarea name="reason" placeholder="{{ $appointment->reason }}"></textarea>
            </div>
            <div class="field">
                <label for="date">Fecha</label>
                <input type="datetime-local" name="date" value="{{ $appointment->date }}" />
            </div>
    
            <button type="submit">Editar cita</button>
            <a href="{{ url('/appointments') }}" class="button">Cancelar</a>
        </form>
    </section>
</div>