<script setup lang="ts">
import { computed, ref } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';

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

const props = defineProps<{
    appointments: Appointment[];
    users: User[];
}>();

const form = useForm({
    user_id: props.users.length > 0 ? props.users[0].id : '',
    reason: '',
    date: '',
});

function submit() {
    form.post('/appointments', {
        onSuccess: () => {
            form.reset('reason', 'date');
        },
    });
}

const searchQuery = ref('');

const filteredAppointments = computed(() => {
    if (!searchQuery.value.trim()) {
        return props.appointments;
    }
    const query = searchQuery.value.toLowerCase().trim();
    return props.appointments.filter((item) => {
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

function deleteAppointment(appointment: Appointment) {
    if (confirm('¿Seguro que desea eliminar esta cita medica?')) {
        router.delete(`/appointments/${appointment.id}`);
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
        <Head title="Citas medicas" />

        <h1>Citas medicas</h1>

        <section class="appointment-form">
            <h1>Crear cita</h1>
            <form @submit.prevent="submit">
                <div class="field">
                    <label for="user_id">Paciente</label>
                    <select
                        id="user_id"
                        v-model="form.user_id"
                        required
                        class="select-input"
                    >
                        <option value="" disabled>Seleccione un paciente</option>
                        <option
                            v-for="user in users"
                            :key="user.id"
                            :value="user.id"
                        >
                            {{ user.name }} (ID: {{ user.id }})
                        </option>
                    </select>
                    <span v-if="form.errors.user_id" class="error-msg">
                        {{ form.errors.user_id }}
                    </span>
                </div>

                <div class="field">
                    <label for="reason">Motivo de consulta</label>
                    <textarea
                        id="reason"
                        v-model="form.reason"
                        required
                    ></textarea>
                    <span v-if="form.errors.reason" class="error-msg">
                        {{ form.errors.reason }}
                    </span>
                </div>

                <div class="field">
                    <label for="date">Fecha</label>
                    <input
                        id="date"
                        v-model="form.date"
                        type="datetime-local"
                        required
                    />
                    <span v-if="form.errors.date" class="error-msg">
                        {{ form.errors.date }}
                    </span>
                </div>

                <button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Agendando...' : 'Agendar cita' }}
                </button>
            </form>
        </section>

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
                    <span class="count-badge">
                        {{ filteredAppointments.length }} de {{ appointments.length }} citas
                    </span>
                </div>
            </div>

            <template v-if="filteredAppointments.length > 0">
                <article
                    v-for="appointment in filteredAppointments"
                    :key="appointment.id"
                    class="appointment"
                >
                    <h3>
                        Nombre del paciente:
                        {{ appointment.user?.name || `Paciente #${appointment.user_id}` }}
                    </h3>
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
                        <Link
                            :href="`/appointments/${appointment.id}/edit`"
                            class="button"
                        >
                            Editar
                        </Link>

                        <button
                            type="button"
                            class="btn-delete"
                            @click="deleteAppointment(appointment)"
                        >
                            Eliminar
                        </button>
                    </div>
                </article>
            </template>

            <div v-else class="empty">
                <template v-if="appointments.length === 0">
                    No hay citas agendadas.
                </template>
                <template v-else>
                    No se encontraron citas que coincidan con "{{ searchQuery }}".
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

.select-input {
    border-radius: 5px;
    border: transparent;
    outline: 1px solid #64748b;
    padding: 0.35rem;
    background-color: #fff;
    min-width: 250px;
}

textarea {
    border-radius: 5px;
    border: transparent;
    outline: 1px solid #64748b;
    padding: 0.35rem;
    width: 100%;
    min-height: 80px;
    font-family: inherit;
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

