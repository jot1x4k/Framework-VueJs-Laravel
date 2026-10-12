import { createApp } from 'vue';
import FlashAlert from './components/FlashAlert.vue';
import UsersList from './components/UsersList.vue';
import AppointmentsList from './components/AppointmentsList.vue';

const appElement = document.getElementById('app');

if (appElement) {
    if (appElement.hasAttribute('data-page')) {
        import('@inertiajs/vue3').then(({ createInertiaApp }) => {
            const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
            void createInertiaApp({
                title: (title) => (title ? `${title} - ${appName}` : appName),
                progress: {
                    color: '#4B5563',
                },
            });
        });
    } else {
        const app = createApp({});

        app.component('FlashAlert', FlashAlert);
        app.component('UsersList', UsersList);
        app.component('AppointmentsList', AppointmentsList);

        app.directive('focus', {
            mounted: (el: HTMLElement, shouldFocus) => {
                if (shouldFocus.value !== false) {
                    el.focus();
                }
            },
        });

        app.mount('#app');
    }
}
