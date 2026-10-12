<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Citas medicas</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<div>
    <h1>Usuarios</h1>
    <section class="user-form">
        <h1>Editar usuario</h1>
        <form method="POST" action="/users/{{ $user->id }}">
            @csrf <!-- Token automatico-->
            @method('PUT')

            <div class="field">
                <label for="name">Nombre completo</label>
                <input type="text" name="name" placeholder="{{ $user->name }}">
            </div>
            <div class="field">
                <label for="name">Correo electronico</label>
                <input type="email" name="email" placeholder="{{ $user->email }}">
            </div>
            <div class="field">
                <label for="name">Contraseña</label>
                <input type="password" name="password">
            </div>
            <button type="submit">Confirmar</button>
            <a href="{{ url('/users') }}" class="button">Cancelar</a>
        </form>
    </section>
</div>