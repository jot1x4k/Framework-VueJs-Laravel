<script setup lang="ts">
import { computed, ref } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';

interface User {
    id: number;
    name: string;
    email: string;
    created_at?: string;
}

const props = defineProps<{
    users: User[];
}>();

const form = useForm({
    name: '',
    email: '',
    password: '',
});

function submit() {
    form.post('/users', {
        onSuccess: () => {
            form.reset();
        },
    });
}

const searchQuery = ref('');

const filteredUsers = computed(() => {
    if (!searchQuery.value.trim()) {
        return props.users;
    }
    const query = searchQuery.value.toLowerCase().trim();
    return props.users.filter(
        (u) =>
            u.name.toLowerCase().includes(query) ||
            u.email.toLowerCase().includes(query)
    );
});

function deleteUser(user: User) {
    if (confirm(`¿Seguro que desea eliminar el usuario "${user.name}"?`)) {
        router.delete(`/users/${user.id}`);
    }
}

function formatDate(dateStr?: string): string {
    if (!dateStr) return '';
    try {
        const d = new Date(dateStr);
        if (isNaN(d.getTime())) return dateStr;
        return d.toLocaleString('es-ES');
    } catch {
        return dateStr;
    }
}
</script>

<template>
    <AppLayout>
        <Head title="Usuarios" />

        <h1>Usuarios</h1>

        <section class="user-form">
            <h1>Crear Usuario</h1>
            <form @submit.prevent="submit">
                <div class="field">
                    <label for="name">Nombre completo</label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        required
                    />
                    <span v-if="form.errors.name" class="error-msg">
                        {{ form.errors.name }}
                    </span>
                </div>

                <div class="field">
                    <label for="email">Correo electronico</label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        required
                    />
                    <span v-if="form.errors.email" class="error-msg">
                        {{ form.errors.email }}
                    </span>
                </div>

                <div class="field">
                    <label for="password">Contraseña</label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        required
                    />
                    <span v-if="form.errors.password" class="error-msg">
                        {{ form.errors.password }}
                    </span>
                </div>

                <button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Guardando...' : '+ Crear usuario' }}
                </button>
            </form>
        </section>

        <section class="users-list">
            <div class="list-header">
                <h1>Listado de Usuarios</h1>
                <div class="search-box">
                    <input
                        v-model="searchQuery"
                        type="search"
                        placeholder="Buscar por nombre o correo..."
                        class="search-input"
                    />
                    <span class="count-badge">
                        {{ filteredUsers.length }} de {{ users.length }} usuarios
                    </span>
                </div>
            </div>

            <template v-if="filteredUsers.length > 0">
                <article
                    v-for="user in filteredUsers"
                    :key="user.id"
                    class="user"
                >
                    <h3>Nombre: {{ user.name }}</h3>
                    <p>
                        <strong>Correo electronico:</strong>
                        {{ user.email }}
                    </p>
                    <p>
                        <strong>Fecha de registro:</strong>
                        {{ formatDate(user.created_at) }}
                    </p>

                    <div class="actions">
                        <Link :href="`/users/${user.id}/edit`" class="button">
                            Editar
                        </Link>

                        <button
                            type="button"
                            class="btn-delete"
                            @click="deleteUser(user)"
                        >
                            Eliminar
                        </button>
                    </div>
                </article>
            </template>

            <div v-else class="empty">
                <template v-if="users.length === 0">
                    No hay usuarios registrados.
                </template>
                <template v-else>
                    No se encontraron usuarios que coincidan con "{{ searchQuery }}".
                </template>
            </div>
        </section>
    </AppLayout>
</template>

<style scoped>
.error-msg {
    color: #dc2626;
    font-size: 0.85rem;
    margin-top: 4px;
}

.list-header {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 8px;
}

@media (min-width: 640px) {
    .list-header {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
}

.search-box {
    display: flex;
    align-items: center;
    gap: 12px;
}

.search-input {
    min-width: 240px;
    padding: 6px 12px;
}

.count-badge {
    color: var(--muted);
    font-size: 0.85rem;
    white-space: nowrap;
}

.actions {
    display: flex;
    gap: 8px;
    margin-top: 12px;
    align-items: center;
}
</style>

