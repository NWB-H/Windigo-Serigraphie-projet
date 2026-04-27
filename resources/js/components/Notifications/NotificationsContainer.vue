<template>
    <div class="notifications__container">
        <ul>
            <AppNotification
                v-for="notification in notifications"
                :key="notification.message + notification.type"
                :message="notification.message"
                :type="notification.type"
            />
        </ul>
    </div>
</template>

<script setup lang="ts">
import AppNotification from '@/components/AppNotification.vue';
import { Notification } from '@/types/globals';
import { router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const notifications = computed<Notification[]>(() => page.props.notifications);

router.on('flash', (event) => {
    event.preventDefault();

    if (event.detail.flash.notification) {
        notifications.value.push(event.detail.flash.notification);
    }
});
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
