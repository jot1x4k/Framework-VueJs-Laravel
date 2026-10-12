<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';

interface User {
    id: number;
    name: string;
    email: string;
}

const props = defineProps<{
    user: User;
}>();

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
});

function submit() {
    form.put(`/users/${props.user.id}`);
}
</script>

<template>
    <AppLayout>
        <Head title="Editar Usuario" />

        <h1>Usuarios</h1>

        <section class="user-form">
            <h1>Editar usuario</h1>
            <form @submit.prevent="submit">
                <div class="field">
                    <label for="name">Nombre completo</label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
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
                    />
                    <span v-if="form.errors.email" class="error-msg">
                        {{ form.errors.email }}
                    </span>
                </div>

                <div class="field">
                    <label for="password">Contraseña (dejar en blanco para conservar actual)</label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                    />
                    <span v-if="form.errors.password" class="error-msg">
                        {{ form.errors.password }}
                    </span>
                </div>

                <div class="form-actions">
                    <button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Guardando...' : 'Confirmar' }}
                    </button>
                    <Link href="/users" class="button btn-cancel">
                        Cancelar
                    </Link>
                </div>
            </form>
        </section>
    </AppLayout>
</template>

<style scoped>
.error-msg {
    color: #dc2626;
    font-size: 0.85rem;
    margin-top: 4px;
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

