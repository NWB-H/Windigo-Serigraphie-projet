import '../css/app.css';
import '../css/app.scss'

import { useCartStore } from '@/stores/Cart';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createPinia } from 'pinia';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { route, ZiggyVue } from 'ziggy-js';
import { Ziggy } from './ziggy';

const pinia = createPinia();

const cartStore = useCartStore(pinia);

cartStore.$subscribe(
    (mutation, state) => {
        localStorage.setItem('cart', JSON.stringify(state.items));
    },
    { flush: 'sync' },
);

createInertiaApp({
    title: (title) => `${title} | Windigo`,
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(pinia)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// @ts-expect-error: route is not defined on window
window.route = route;
