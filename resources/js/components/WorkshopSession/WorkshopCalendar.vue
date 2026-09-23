<template>
    <div
        class="@container flex h-full w-full flex-col rounded-2xl border border-gray-100 bg-white px-4 py-4 @lg:px-6 @lg:py-6 @3xl:px-10 @3xl:py-8"
    >
        <!-- Header -->
        <div
            class="mb-4 flex shrink-0 items-center justify-between @lg:mb-6 @3xl:mb-10"
        >
            <AppButton
                ignoreStyle
                @click="handleDecreaseMonth"
                type="button"
                class="flex h-8 w-8 items-center justify-center text-2xl text-gray-900 @lg:h-10 @lg:w-10 @lg:text-3xl @3xl:h-12 @3xl:w-12 @3xl:text-5xl"
            >
                ‹
            </AppButton>

            <h2
                class="text-lg font-semibold text-gray-900 @lg:text-xl @3xl:text-3xl"
            >
                {{ useDateFormat(date, 'MMMM YYYY') }}
            </h2>

            <AppButton
                ignoreStyle
                @click="handleAddMonth"
                type="button"
                class="flex h-8 w-8 items-center justify-center text-2xl text-gray-900 @lg:h-10 @lg:w-10 @lg:text-3xl @3xl:h-12 @3xl:w-12 @3xl:text-5xl"
            >
                ›
            </AppButton>
        </div>

        <!-- Jours de la semaine -->
        <div class="mb-3 grid shrink-0 grid-cols-7 @lg:mb-5 @3xl:mb-8">
            <div
                class="text-center text-sm font-medium text-gray-400 @lg:text-lg @3xl:text-2xl"
            >
                L
            </div>
            <div
                class="text-center text-sm font-medium text-gray-400 @lg:text-lg @3xl:text-2xl"
            >
                M
            </div>
            <div
                class="text-center text-sm font-medium text-gray-400 @lg:text-lg @3xl:text-2xl"
            >
                M
            </div>
            <div
                class="text-center text-sm font-medium text-gray-400 @lg:text-lg @3xl:text-2xl"
            >
                J
            </div>
            <div
                class="text-center text-sm font-medium text-gray-400 @lg:text-lg @3xl:text-2xl"
            >
                V
            </div>
            <div
                class="text-center text-sm font-medium text-gray-400 @lg:text-lg @3xl:text-2xl"
            >
                S
            </div>
            <div
                class="text-center text-sm font-medium text-gray-400 @lg:text-lg @3xl:text-2xl"
            >
                D
            </div>
        </div>

        <div
            class="grid flex-1 auto-rows-fr grid-cols-7 gap-y-1 @lg:gap-y-2 @3xl:gap-y-3"
        >
            <div v-for="n in leadingBlanks" :key="'blank-' + n"></div>

            <div
                v-for="day in totalDaysInMonth"
                :key="day"
                @click="handleSelectDate(day)"
                class="flex h-full min-h-10 items-center justify-center @lg:min-h-14 @3xl:min-h-20"
            >
                <AppButton
                    ignoreStyle
                    type="button"
                    class="relative flex items-center justify-center rounded-full! text-sm font-medium @lg:text-lg @3xl:text-2xl"
                    :class="[
                        day === selectedDate
                            ? 'bg-[#B98F76] text-white'
                            : 'text-gray-600',
                        hasSession(day)
                            ? 'h-10 w-10 @lg:h-14 @lg:w-14 @3xl:h-20 @3xl:w-20'
                            : 'h-8 w-8 @lg:h-12 @lg:w-12 @3xl:h-16 @3xl:w-16',
                    ]"
                >
                    {{ day }}
                    <span
                        v-if="hasSession(day)"
                        class="absolute bottom-0.5 h-1.5 w-1.5 rounded-full bg-[#D4A05F] @lg:bottom-1 @lg:h-2 @lg:w-2 @3xl:h-2.5 @3xl:w-2.5"
                    ></span>
                </AppButton>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import AppButton from '@/components/Global/AppButton.vue';
import { useDateFormat } from '@vueuse/shared';
import { WorkshopSession } from '@/models';

const { sessions = undefined, date = new Date() } = defineProps<{
    sessions?: Record<number, WorkshopSession[]>;
    date?: Date;
}>();

const emits = defineEmits<{
    (e: 'selectDate', date: Date): void;
    (e: 'changeMonth', date: Date): void;
}>();

const currentMonth = computed(
    () => new Date(date.getFullYear(), date.getMonth(), 1),
);

const leadingBlanks = computed(() => (currentMonth.value.getDay() + 6) % 7);

const totalDaysInMonth = computed(() =>
    new Date(
        currentMonth.value.getFullYear(),
        currentMonth.value.getMonth() + 1,
        0,
    ).getDate(),
);

const selectedDate = computed(() => date.getDate());

function hasSession(day: number) {
    return (sessions?.[day]?.length ?? 0) > 0;
}

function handleSelectDate(day: number) {
    emits('selectDate', new Date(date.getFullYear(), date.getMonth(), day));
}

function handleAddMonth() {
    emits(
        'changeMonth',
        new Date(date.getFullYear(), date.getMonth() + 1, selectedDate.value),
    );
}

function handleDecreaseMonth() {
    emits(
        'changeMonth',
        new Date(date.getFullYear(), date.getMonth() - 1, selectedDate.value),
    );
}
</script>

<style scoped></style>
