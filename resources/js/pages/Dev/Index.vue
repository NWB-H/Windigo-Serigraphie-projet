<template>
    <div class="container">
        <WorkshopCalendar
            :sessionsDays="[10, 21]"
            :date="date"
            @addMonth="handleAddMonth"
            @decreaseMonth="handleDecreaseMonth"
            @selectDate="handleSelectDate"
        />
    </div>
</template>

<script setup lang="ts">
import AppLayoutAdmin from '@/layouts/AppLayoutAdmin.vue';
import WorkshopCalendar from '@/components/WorkshopSession/WorkshopCalendar.vue';
import { ref } from 'vue';

defineOptions({
    layout: AppLayoutAdmin,
});

const date = ref(new Date());

function handleAddMonth() {
    date.value = new Date(date.value.getFullYear(), date.value.getMonth() + 1, date.value.getDate());
}

function handleDecreaseMonth() {
    date.value = new Date(date.value.getFullYear(), date.value.getMonth() - 1, date.value.getDate());
}

function handleSelectDate(day: number) {
    date.value = new Date(date.value.getFullYear(), date.value.getMonth(), day);
}
</script>

<style scoped></style>
