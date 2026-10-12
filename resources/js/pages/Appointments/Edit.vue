<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
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
    appointment: Appointment;
}>();

const form = useForm({
    reason: props.appointment.reason,
    date: props.appointment.date,
});

function submit() {
    form.put(`/appointments/${props.appointment.id}`);
}
</script>

<template>
    <AppLayout>
        <Head title="Editar Cita Medica" />

        <h1>Citas medicas</h1>

        <section class="appointment-form">
            <h1>Editar cita</h1>
            <p v-if="appointment.user" class="patient-info">
                <strong>Paciente:</strong> {{ appointment.user.name }} ({{ appointment.user.email }})
            </p>

            <form @submit.prevent="submit">
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

                <div class="form-actions">
                    <button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Guardando...' : 'Editar cita' }}
                    </button>
                    <Link href="/appointments" class="button btn-cancel">
                        Cancelar
                    </Link>
                </div>
            </form>
        </section>
    </AppLayout>
</template>

<style scoped>
.patient-info {
    margin-bottom: 16px;
    color: var(--muted);
    font-size: 0.95rem;
}

.error-msg {
    color: #dc2626;
    font-size: 0.85rem;
    margin-top: 4px;
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

.form-actions {
    margin-top: 16px;
    display: flex;
    gap: 8px;
    align-items: center;
}

.btn-cancel {
    background-color: #64748b;
}

.btn-cancel:hover {
    background-color: #475569;
}
</style>

