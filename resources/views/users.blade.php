<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Usuarios</title>

    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>

<body>
    <div id="app">
        <x-header />
        <main>
            <h1>Usuarios</h1>

            @if (session('success'))
                <flash-alert message="{{ session('success') }}" type="success"></flash-alert>
            @endif

            <section class="user-form">
                <h1>Crear Usuario</h1>
                <form method="POST" action="/users">
                    @csrf
                    <div class="field">
                        <label for="name">Nombre completo</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="field">
                        <label for="email">Correo electronico</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="field">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit">+ Crear usuario</button>
                </form>
            </section>

            <users-list :initial-users='@json($users)' csrf-token="{{ csrf_token() }}"></users-list>
        </main>
    </div>
</body>

</html>