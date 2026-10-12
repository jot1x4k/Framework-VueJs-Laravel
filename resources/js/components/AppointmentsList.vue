<script setup lang="ts">
import { computed, ref } from 'vue';

interface User {
    id: number;
    name: string;
    email: string;
}

interface Appointment {
    id: number;
    user_id: number;
    reason: string;
    date: string;
    user?: User;
}

const props = withDefaults(
    defineProps<{
        initialAppointments?: Appointment[];
        csrfToken?: string;
    }>(),
    {
        initialAppointments: () => [],
        csrfToken: '',
    }
);

const searchQuery = ref('');

const filteredAppointments = computed(() => {
    if (!searchQuery.value.trim()) {
        return props.initialAppointments;
    }
    const query = searchQuery.value.toLowerCase().trim();
    return props.initialAppointments.filter((item) => {
        const userName = item.user?.name?.toLowerCase() || '';
        const userEmail = item.user?.email?.toLowerCase() || '';
        const reason = item.reason?.toLowerCase() || '';
        return (
            userName.includes(query) ||
            userEmail.includes(query) ||
            reason.includes(query)
        );
    });
});

function confirmDelete(): boolean {
    return confirm('¿Seguro que desea eliminar esta cita medica?');
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
    <section class="appointment-list">
        <div class="list-header">
            <h1>Listado de citas medicas</h1>
            <div class="search-box">
                <input
                    v-model="searchQuery"
                    type="search"
                    placeholder="Buscar paciente o motivo..."
                    class="search-input"
                />
                <span class="appointment-count">
                    {{ filteredAppointments.length }} de {{ initialAppointments.length }} citas
                </span>
            </div>
        </div>

        <template v-if="filteredAppointments.length > 0">
            <article
                v-for="appointment in filteredAppointments"
                :key="appointment.id"
                class="appointment"
            >
                <h3>Nombre del paciente: {{ appointment.user?.name || `Paciente #${appointment.user_id}` }}</h3>
                <p v-if="appointment.user?.email">
                    <strong>Correo electronico:</strong>
                    {{ appointment.user.email }}
                </p>
                <p>
                    <strong>Motivo:</strong>
                    {{ appointment.reason }}
                </p>
                <p>
                    <strong>Fecha:</strong>
                    {{ formatDate(appointment.date) }}
                </p>

                <div class="actions">
                    <a :href="`/appointments/${appointment.id}/edit`" class="button">
                        Editar
                    </a>

                    <form
                        method="POST"
                        :action="`/appointments/${appointment.id}`"
                        @submit="($event) => { if (!confirmDelete()) $event.preventDefault(); }"
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
            <template v-if="initialAppointments.length === 0">
                No hay citas agendadas.
            </template>
            <template v-else>
                No se encontraron citas que coincidan con "{{ searchQuery }}".
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

.appointment-count {
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

