<template>
    <div class="container">
        <WorkshopSelector
            :selectedDate="date"
            :duration="60"
            workshopName="test"
            :sessions="sessions"
        />
    </div>
</template>

<script setup lang="ts">
import AppLayoutAdmin from '@/layouts/AppLayoutAdmin.vue';
import { ref } from 'vue';
import WorkshopSelector from '@/components/WorkshopSession/WorkshopSelector.vue';
import { WorkshopSession } from '@/models';

defineOptions({
    layout: AppLayoutAdmin,
});

const date = ref(new Date());
const sessions = ref<WorkshopSession[]>([
    {
        id: 1,
        workshop_id: 1,
        session_number: 1,
        date: '12/12/2012',
        remaining_places: 10,
        capacity: 20,
    },
    {
        id: 2,
        workshop_id: 1,
        session_number: 1,
        date: '12/12/2012',
        remaining_places: 0,
        capacity: 20,
    },
]);
</script>

<style scoped></style>
