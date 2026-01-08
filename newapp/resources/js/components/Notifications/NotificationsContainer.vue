<template>
    <div class="notifications__container">
        <ul>
            <AppNotification
                v-for="toast in page.flash.toasts"
                :key="toast.message + toast.type"
                :message="toast.message"
                :type="toast.type"
            />
        </ul>
    </div>
</template>

<script setup lang="ts">
import AppNotification from "@/components/AppNotification.vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage()
</script>

<style scoped>
.notifications__container {
    position: fixed;
    bottom: 16px;
    right: 16px;

    ul {
        display: flex;
        flex-direction: column-reverse;
        gap: 14px;
    }
}
</style>
