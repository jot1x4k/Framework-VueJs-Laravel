<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editar Usuario</title>

    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>

<body>
    <div id="app">
        <x-header />
        <main>
            <h1>Usuarios</h1>
            <section class="user-form">
                <h1>Editar usuario</h1>
                <form method="POST" action="/users/{{ $user->id }}">
                    @csrf
                    @method('PUT')

                    <div class="field">
                        <label for="name">Nombre completo</label>
                        <input type="text" id="name" name="name" placeholder="{{ $user->name }}" value="{{ $user->name }}">
                    </div>
                    <div class="field">
                        <label for="email">Correo electronico</label>
                        <input type="email" id="email" name="email" placeholder="{{ $user->email }}" value="{{ $user->email }}">
                    </div>
                    <div class="field">
                        <label for="password">Contraseña (dejar en blanco para conservar actual)</label>
                        <input type="password" id="password" name="password">
                    </div>
                    <div style="margin-top: 12px; display: flex; gap: 8px;">
                        <button type="submit">Confirmar</button>
                        <a href="{{ url('/users') }}" class="button" style="background-color: #64748b;">Cancelar</a>
                    </div>
                </form>
            </section>
        </main>
    </div>
</body>

</html>