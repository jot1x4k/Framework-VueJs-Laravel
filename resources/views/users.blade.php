<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuarios</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <x-header />
    <main>
        <h1>Usuarios</h1>
        <section class="user-form">
            <h1>Crear Usuario</h1>
            <form method="POST" action="/users">
                @csrf <!-- Token automatico-->
                <div class="field">
                    <label for="name">Nombre completo</label>
                    <input type="text" name="name" required>
                </div>
                <div class="field">
                    <label for="name">Correo electronico</label>
                    <input type="email" name="email" required>
                </div>
                <div class="field">
                    <label for="name">Contraseña</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit">+ Crear usuario</button>
            </form>
        </section>
        <section class="users-list">
            <h1>Listado de Usuarios</h1>
            @forelse ($users as $user)
                <article class="user">
                    <h3>Nombre: {{ $user->name }}</h3>
                    <p>
                        <strong>Correo electronico:</strong>
                        {{ $user->email }}
                    </p>
                    <p>
                        <strong>Fecha de registro:</strong>
                        {{ $user->created_at }}
                    </p>
                    <a href="/users/{{ $user->id }}/edit" class="button">
                        Editar
                    </a>

                    <form method="POST" action="/users/{{ $user->id }}" onsubmit="return confirm('Seguro que desea eliminar este usuario?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="btn-delete">
                            Eliminar
                        </button>
                    </form>
                </article>
            @empty
                <div class="empty">
                    No hay usuarios registrados.
                </div>
            @endforelse
        </section>
    </main>
</body>

</html>