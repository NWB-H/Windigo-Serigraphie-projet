<template>
    <span
        class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1 text-sm font-medium"
        :class="'text-' + color + '-500!'"
    >
        <span
            class="h-2 w-2 rounded-full"
            :class="'bg-' + color + '-500!'"
        ></span>
        {{ status }}
    </span>
</template>

<script setup lang="ts">
import { OrderState } from "@/models";
import { computed } from "vue";

const props = defineProps<{
    status: OrderState
}>()

const color = computed(() => {
    switch (props.status) {
        case "annulée":
            return 'red';
        case "payée":
            return 'green';
        default:
            return 'yellow';
    }
})
</script>

<style scoped>

</style>
