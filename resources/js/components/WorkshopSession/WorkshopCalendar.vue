<template>
    <div class="w-full rounded-2xl border border-gray-100 bg-white px-10 py-8">
        <!-- Header -->
        <div class="mb-10 flex items-center justify-between">
            <AppButton
                ignoreStyle
                @click="handleDecreaseMonth"
                type="button"
                class="flex h-12 w-12 items-center justify-center text-5xl text-gray-900"
            >
                ‹
            </AppButton>

            <h2 class="text-3xl font-semibold text-gray-900">{{ useDateFormat(date, 'MMMM YYYY') }}</h2>

            <AppButton
                ignoreStyle
                @click="handleAddMonth"
                type="button"
                class="flex h-12 w-12 items-center justify-center text-5xl text-gray-900"
            >
                ›
            </AppButton>
        </div>

        <!-- Jours de la semaine -->
        <div class="mb-8 grid grid-cols-7">
            <div class="text-center text-2xl font-medium text-gray-400">L</div>
            <div class="text-center text-2xl font-medium text-gray-400">M</div>
            <div class="text-center text-2xl font-medium text-gray-400">M</div>
            <div class="text-center text-2xl font-medium text-gray-400">J</div>
            <div class="text-center text-2xl font-medium text-gray-400">V</div>
            <div class="text-center text-2xl font-medium text-gray-400">S</div>
            <div class="text-center text-2xl font-medium text-gray-400">D</div>
        </div>

        <div class="grid grid-cols-7 gap-y-3">
            <div
                v-for="passDay in currentMonth.getDay() - 1"
                :key="passDay"
            ></div>

            <div
                v-for="day in totalDaysInMonth"
                :key="day"
                @click="handleSelectDate(day)"
                class="flex h-20 items-center justify-center"
            >
                <AppButton
                    ignoreStyle
                    type="button"
                    class="relative flex items-center justify-center rounded-full! text-2xl font-medium"
                    :class="[
                        day === selectedDate
                            ? 'bg-[#B98F76] text-white'
                            : 'text-gray-600',
                        hasSession(day) ? 'h-20 w-20' : 'h-16 w-16',
                    ]"
                >
                    {{ day }}
                    <span
                        v-if="hasSession(day)"
                        class="absolute bottom-1 h-2.5 w-2.5 rounded-full bg-[#D4A05F]"
                    ></span>
                </AppButton>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import AppButton from '@/components/Global/AppButton.vue';
import { useDateFormat } from '@vueuse/shared';

const { sessionsDays = [], date = new Date() } = defineProps<{
    sessionsDays?: number[],
    date?: Date,
}>()

const emits = defineEmits<{
    (e: 'selectDate', date: number): void,
    (e: 'addMonth'): void,
    (e: 'decreaseMonth'): void,
}>()

const currentMonth = ref(new Date(
    date.getFullYear(),
    date.getMonth(),
    1,
));

const totalDaysInMonth = ref(new Date(
    currentMonth.value.getFullYear(),
    currentMonth.value.getMonth() + 1,
    0,
).getDate());

const selectedDate = ref(date.getDate());

function hasSession(day: number) {
    return sessionsDays.includes(day);
}

function handleSelectDate(day: number) {
    selectedDate.value = day;
    emits('selectDate', day);
}

function handleAddMonth() {
    emits('addMonth');
}

function handleDecreaseMonth() {
    emits('decreaseMonth');
}
</script>

<style scoped></style>
