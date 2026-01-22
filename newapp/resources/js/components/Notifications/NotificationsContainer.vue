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
import {Toast} from "@/types/globals";

const page = usePage()

const toasts = ref<Toast[]>(page.flash.toasts ?? [])

router.on('flash', (event) => {
  event.preventDefault()

  if (event.detail.flash.toast) {
    toasts.value.push(event.detail.flash.toast)
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
