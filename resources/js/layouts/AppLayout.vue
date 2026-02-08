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
    </div>
</template>

<script setup lang="ts">
import AppHeader from "@/components/AppHeader.vue";
import AppFooter from "@/components/AppFooter.vue";
import NotificationsContainer from "@/components/Notifications/NotificationsContainer.vue";
import {Head} from "@inertiajs/vue3";

defineProps<{ title?: string }>()
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
