<template>
    <div class="@container flex flex-1 w-full flex-col p-4 @lg:p-6 @3xl:p-8">
        <div
            class="mb-6 flex shrink-0 items-center justify-between @lg:mb-8 @3xl:mb-12"
        >
            <div class="flex items-center gap-3 @lg:gap-4 @3xl:gap-5">
                <CalendarIcon
                    class="h-8 w-8 text-gray-800 @lg:h-10 @lg:w-10 @3xl:h-12 @3xl:w-12"
                />
                <h1
                    class="text-xl font-medium tracking-wide text-gray-800 uppercase @lg:text-2xl @3xl:text-4xl"
                >
                    Choisir une date
                </h1>
            </div>

            <div class="flex items-center gap-4 @lg:gap-8 @3xl:gap-12">
                <button
                    type="button"
                    class="text-2xl text-gray-800 transition hover:opacity-60 @lg:text-3xl @3xl:text-5xl"
                    @click="selectedYear--"
                >
                    ‹
                </button>
                <span
                    id="year"
                    class="text-xl font-semibold text-gray-900 @lg:text-2xl @3xl:text-4xl"
                    >{{ selectedYear }}</span
                >
                <button
                    type="button"
                    class="text-2xl text-gray-800 transition hover:opacity-60 @lg:text-3xl @3xl:text-5xl"
                    @click="selectedYear++"
                >
                    ›
                </button>
            </div>
        </div>

        <div
            class="grid min-h-0 flex-1 grid-cols-4 grid-rows-3 gap-2 @lg:gap-4 @3xl:gap-6"
        >
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
                class="h-full w-full min-h-14 rounded border-2 text-sm @lg:min-h-20 @lg:text-base @3xl:min-h-28 @3xl:border-3 @3xl:text-lg"
            >
                {{ month.label }}
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import CalendarIcon from '@/components/Icon/CalendarIcon.vue';

const props = defineProps<{ date: Date }>()

const emits = defineEmits<{
    (e: 'click', value: Date): void;
}>();

const selectedYear = ref(props.date.getFullYear());
const selectedMonth = ref(props.date.getMonth() + 1);

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
