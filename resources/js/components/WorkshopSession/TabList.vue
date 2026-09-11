<template>
    <div class="flex items-center gap-2 border-b border-gray-200 px-6 pt-5">
        <button
            v-for="item in items"
            :key="item.label"
            @click="$emit('click', item.value)"
            type="button"
            class="relative px-4 pb-4 text-sm font-semibold"
            :class="[
                item.isActive
                    ? 'text-[#b18e76]'
                    : 'text-gray-400 transition hover:text-gray-700',
            ]"
        >
            {{ item.label }}
            <span
                class="ml-2 rounded-full px-2 py-0.5 text-xs"
                :class="[
                    item.isActive
                        ? 'bg-[#b18e76]/10 text-[#b18e76]'
                        : 'bg-gray-100 text-gray-500',
                ]"
                >{{ item.count }}</span
            >
            <span
                v-if="item.isActive"
                class="absolute bottom-0 left-0 h-0.5 w-full bg-[#b18e76]"
            ></span>
        </button>
    </div>
</template>

<script setup lang="ts">
import { WorkshopSessionTabItem } from '@/models';

defineProps<{ items: WorkshopSessionTabItem[] }>();

defineEmits(['click']);
</script>

<style scoped></style>
