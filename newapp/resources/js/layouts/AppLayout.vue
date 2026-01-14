<template>
    <div>
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
</script>

<style>
main {
    min-height: 80vh;
    font-family: 'Oswald', sans-serif;
    font-weight: 200; /* Extralight */
}
</style>
