<template>
    <div>
        <slot name="head">
            <Head>
                <title v-if="title">{{ title }}</title>
            </Head>
        </slot>
        <AppHeader />
        <main class="position-relative">
            <slot />
            <NotificationsContainer />
        </main>
        <AppFooter />
        <AppModalFullScreen v-if="showModal">
            <component :is="currentModalComponent" v-bind="modalProps" />
        </AppModalFullScreen>
    </div>
</template>

<script setup lang="ts">
import AppFooter from '@/components/AppFooter.vue';
import AppHeader from '@/components/AppHeader.vue';
import NotificationsContainer from '@/components/Notifications/NotificationsContainer.vue';
import { Head } from '@inertiajs/vue3';
import AppModalFullScreen from '@/components/AppModalFullScreen.vue';
import { provide } from 'vue';
import { modalKey } from '@/keys';
import { useModal } from '@/composable/useModal';

defineProps<{ title?: string }>();

const {
    showModal,
    currentModalComponent,
    modalProps,
    updateModal,
    toggleModal,
} = useModal();

provide(modalKey, {
    updateModal,
    toggleModal,
});
</script>

<style>
main {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 80vh;
    font-family: 'Oswald', sans-serif;
    font-weight: 200; /* Extralight */
}
</style>
