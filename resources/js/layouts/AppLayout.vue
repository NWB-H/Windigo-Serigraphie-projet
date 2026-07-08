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
        <AppModalFullScreen v-if="showModal"> </AppModalFullScreen>
    </div>
</template>

<script setup lang="ts">
import AppFooter from '@/components/AppFooter.vue';
import AppHeader from '@/components/AppHeader.vue';
import NotificationsContainer from '@/components/Notifications/NotificationsContainer.vue';
import { Head } from '@inertiajs/vue3';
import AppModalFullScreen from '@/components/AppModalFullScreen.vue';
import { computed, provide, ref } from 'vue';
import { modalKey } from '@/keys';

defineProps<{ title?: string }>();

const showModal = computed(() => currentModal.value !== null);
const currentModal = ref<string | null>(null);

function updateModal(modal: string) {
    currentModal.value = modal;
}

provide(modalKey, {
    updateModal,
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
