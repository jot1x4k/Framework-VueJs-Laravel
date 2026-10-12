<script setup lang="ts">
import { ref } from 'vue';

const props = withDefaults(
    defineProps<{
        message?: string;
        type?: 'success' | 'error' | 'info';
    }>(),
    {
        type: 'success',
    }
);

const visible = ref(true);

function dismiss() {
    visible.value = false;
}
</script>

<template>
    <div
        v-if="visible && message"
        class="flash-alert"
        :class="`flash-alert--${type}`"
    >
        <div class="flash-alert__content">
            <span class="flash-alert__icon">
                <template v-if="type === 'success'">✓</template>
                <template v-else-if="type === 'error'">✕</template>
                <template v-else>ℹ</template>
            </span>
            <span class="flash-alert__text">{{ message }}</span>
        </div>
        <button
            type="button"
            class="flash-alert__close"
            aria-label="Cerrar"
            @click="dismiss"
        >
            &times;
        </button>
    </div>
</template>

<style scoped>
.flash-alert {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    border-radius: var(--radius, 10px);
    margin-bottom: 20px;
    font-size: 0.95rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.flash-alert--success {
    background-color: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.flash-alert--error {
    background-color: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.flash-alert--info {
    background-color: #eff6ff;
    color: #1e40af;
    border: 1px solid #bfdbfe;
}

.flash-alert__content {
    display: flex;
    align-items: center;
    gap: 8px;
}

.flash-alert__icon {
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
}

.flash-alert__close {
    background: transparent !important;
    border: none;
    color: inherit;
    font-size: 1.25rem;
    cursor: pointer;
    padding: 0 4px;
    line-height: 1;
}

.flash-alert__close:hover {
    opacity: 0.7;
}
</style>

