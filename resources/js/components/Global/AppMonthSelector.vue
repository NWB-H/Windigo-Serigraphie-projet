<template>
    <div class="mx-auto w-full max-w-5xl p-8">
        <!-- Header -->
        <div class="mb-12 flex items-center justify-between">
            <div class="flex items-center gap-5">
                <CalendarIcon class="h-12 w-12 text-gray-800" />
                <h1
                    class="text-4xl font-medium tracking-wide text-gray-800 uppercase"
                >
                    Choisir une date
                </h1>
            </div>

            <!-- Navigation année -->
            <div class="flex items-center gap-12">
                <button
                    type="button"
                    class="text-5xl text-gray-800 transition hover:opacity-60"
                    @click="selectedYear--"
                >
                    ‹
                </button>
                <span id="year" class="text-4xl font-semibold text-gray-900">{{
                    selectedYear
                }}</span>
                <button
                    type="button"
                    class="text-5xl text-gray-800 transition hover:opacity-60"
                    @click="selectedYear++"
                >
                    ›
                </button>
            </div>
        </div>

        <!-- Mois -->
        <div class="grid grid-cols-4 gap-6">
            <button
                v-for="month in months"
                :key="month.value"
                @click="handleClick(month.value)"
                type="button"
                :class="[
                    selectedMonth === month.value
                        ? 'border-[#B48F78] bg-[#B48F78] text-white'
                        : 'border-gray-100 bg-white text-gray-600',
                ]"
                class="h-28 rounded border-3"
            >
                {{ month.label }}
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import CalendarIcon from '@/components/Icon/CalendarIcon.vue';

const emits = defineEmits<{
    (e: 'click', value: Date): void;
}>();

const date = new Date();

const selectedYear = ref(date.getFullYear());
const selectedMonth = ref(date.getMonth() + 1);

const months = [
    { label: 'Jan.', value: 1 },
    { label: 'Fév.', value: 2 },
    { label: 'Mars', value: 3 },
    { label: 'Avr.', value: 4 },
    { label: 'Mai', value: 5 },
    { label: 'Juin', value: 6 },
    { label: 'Juil.', value: 7 },
    { label: 'Août', value: 8 },
    { label: 'Sept.', value: 9 },
    { label: 'Oct.', value: 10 },
    { label: 'Nov.', value: 11 },
    { label: 'Déc.', value: 12 },
];

function handleClick(month: number) {
    selectedMonth.value = month;

    emits('click', new Date(selectedYear.value, month - 1, 1));
}
</script>

<style scoped></style>
