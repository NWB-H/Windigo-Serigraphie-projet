<template>
    <div class="notifications__container">
        <ul>
            <AppNotification
                v-for="item in items"
                :key="item.id"
                :notification="item"
            />
        </ul>
    </div>
</template>

<script setup lang="ts">
import AppNotification from "@/components/AppNotification.vue";
import { storeToRefs } from "pinia";
import { useNotificationStore } from "@/stores/Notifications";

const { items } = storeToRefs(useNotificationStore())
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
