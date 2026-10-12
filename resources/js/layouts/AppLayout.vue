<script setup lang="ts">
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import FlashAlert from '../components/FlashAlert.vue';

const page = usePage();

const flashSuccess = computed(() => (page.props.flash as any)?.success as string | undefined);
const flashError = computed(() => (page.props.flash as any)?.error as string | undefined);

const currentUrl = computed(() => page.url);
</script>

<template>
    <div class="layout-container">
        <header>
            <div class="navbar">
                <div class="nav-title">
                    <Link href="/" class="brand-link">
                        <h2>Piedra Azul</h2>
                    </Link>
                </div>

                <nav class="nav-links">
                    <Link
                        href="/users"
                        :class="{ 'active': currentUrl.startsWith('/users') }"
                    >
                        Usuarios
                    </Link>
                    <Link
                        href="/appointments"
                        :class="{ 'active': currentUrl.startsWith('/appointments') }"
                    >
                        Citas medicas
                    </Link>
                </nav>
            </div>
        </header>

        <main>
            <FlashAlert
                v-if="flashSuccess"
                :key="flashSuccess"
                :message="flashSuccess"
                type="success"
            />
            <FlashAlert
                v-if="flashError"
                :key="flashError"
                :message="flashError"
                type="error"
            />

            <slot />
        </main>
    </div>
</template>

<style scoped>
.layout-container {
    min-height: 100vh;
}

.brand-link {
    text-decoration: none;
    color: inherit;
}

.nav-links a {
    color: var(--muted);
    font-weight: 500;
    transition: color 0.15s ease;
}

.nav-links a:hover,
.nav-links a.active {
    color: var(--primary);
    font-weight: 600;
}
</style>

