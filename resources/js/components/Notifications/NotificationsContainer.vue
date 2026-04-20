<template>
    <div class="notifications__container">
        <ul>
            <AppNotification
                v-for="toast in toasts"
                :key="toast.message + toast.type"
                :message="toast.message"
                :type="toast.type"
            />
        </ul>
    </div>
</template>

<script setup lang="ts">
import AppNotification from "@/components/AppNotification.vue";
import { usePage, router } from "@inertiajs/vue3";
import {ref} from "vue";
import { Notification } from "@/types/globals";

const page = usePage<{ notifications: Notification[] }>()

const toasts = ref<Notification[]>(page.props.notifications ?? [])

router.on('flash', (event) => {
  event.preventDefault()

  if (event.detail.flash.notification) {
    toasts.value.push(event.detail.flash.notification)
  }
})
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
