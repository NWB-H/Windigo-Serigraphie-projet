<template>
    <span :class="notification.type">
        {{ notification.message }}
    </span>
</template>

<script setup lang="ts">
import {Item, useNotificationStore} from '@/stores/Notifications'
import {onMounted, onUnmounted} from "vue";

const props = defineProps<{ notification: Item }>()

const { removeItem } = useNotificationStore()

let interval = null

onMounted(() => {
    interval = setInterval(() => {
        removeItem(props.notification)
    }, 5000)
})

onUnmounted(() => {
    clearInterval(interval)
})
</script>

<style scoped>
span {
    border-radius: 4px;
    padding: 18px;
    color: white;
}

.success {
    background-color: #0a3622;
}

.error {
    background-color: darkred;
}

.warning {
    background-color: darkorange;
}
</style>
