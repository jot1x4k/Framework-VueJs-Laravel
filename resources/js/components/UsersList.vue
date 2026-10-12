<script setup lang="ts">
import { computed, ref } from 'vue';

interface User {
    id: number;
    name: string;
    email: string;
    created_at?: string;
}

const props = withDefaults(
    defineProps<{
        initialUsers?: User[];
        csrfToken?: string;
    }>(),
    {
        initialUsers: () => [],
        csrfToken: '',
    }
);

const searchQuery = ref('');

const filteredUsers = computed(() => {
    if (!searchQuery.value.trim()) {
        return props.initialUsers;
    }
    const query = searchQuery.value.toLowerCase().trim();
    return props.initialUsers.filter(
        (user) =>
            user.name.toLowerCase().includes(query) ||
            user.email.toLowerCase().includes(query)
    );
});

function confirmDelete(userName: string): boolean {
    return confirm(`¿Seguro que desea eliminar el usuario "${userName}"?`);
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
                <span class="user-count">
                    {{ filteredUsers.length }} de {{ initialUsers.length }} usuarios
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
                    <a :href="`/users/${user.id}/edit`" class="button">
                        Editar
                    </a>

                    <form
                        method="POST"
                        :action="`/users/${user.id}`"
                        @submit="($event) => { if (!confirmDelete(user.name)) $event.preventDefault(); }"
                    >
                        <input type="hidden" name="_token" :value="csrfToken" />
                        <input type="hidden" name="_method" value="DELETE" />

                        <button type="submit" class="btn-delete">
                            Eliminar
                        </button>
                    </form>
                </div>
            </article>
        </template>

        <div v-else class="empty">
            <template v-if="initialUsers.length === 0">
                No hay usuarios registrados.
            </template>
            <template v-else>
                No se encontraron usuarios que coincidan con "{{ searchQuery }}".
            </template>
        </div>
    </section>
</template>

<style scoped>
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

.user-count {
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

