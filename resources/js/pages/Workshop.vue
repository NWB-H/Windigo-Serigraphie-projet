<template>
    <div class="container">
        <Link class="btn btn-outline-primary mb-3" :href="route('workshops')">
            ← Retour à la boutique
        </Link>
        <div class="grid grid-cols-10 gap-6 gap-y-6">
            <div class="col-span-6">
                <CarouselWithMiniatures
                    :images="workshop.images"
                    :selectedImageUrl="workshop.highlighted_image?.url"
                />
            </div>
            <div class="col-span-4 flex flex-col">
                <h2>{{ workshop.name }}</h2>
                <h5 class="text-muted">{{ workshop.type }}</h5>
                <p><strong>Prix :</strong> {{ workshop.price }} €</p>
                <p><strong>Durée :</strong> {{ workshop.duration }} min</p>
                <p><strong>Âge minimum :</strong> {{ workshop.age }} ans</p>
                <p class="mt-3">{{ workshop.description }}</p>
                <AppMonthSelector
                    :date="selectedDate"
                    @click="handleChangeDate"
                />
            </div>
            <div class="col-span-5">
                <WorkshopCalendar
                    :date="selectedDate"
                    :sessions="sessions"
                    @selectDate="(value) => (selectedDate = value)"
                    @changeMonth="handleChangeDate"
                />
            </div>
            <div class="col-span-5">
                <WorkshopSelector
                    :selectedDate="selectedDate"
                    :duration="workshop.duration"
                    :workshopName="workshop.name"
                    :sessions="selectedDateSessions"
                />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Workshop, WorkshopSession } from '@/models/Workshop';
import { Link } from '@inertiajs/vue3';
import CarouselWithMiniatures from '@/components/Carousel/CarouselWithMiniatures.vue';
import AppMonthSelector from '@/components/Global/AppMonthSelector.vue';
import WorkshopCalendar from '@/components/WorkshopSession/WorkshopCalendar.vue';
import { ref, computed, watch, onMounted } from 'vue';
import WorkshopRepository from '@/services/WorkshopRepository';
import WorkshopSelector from '@/components/WorkshopSession/WorkshopSelector.vue';

defineOptions({
    layout: (props: { workshop: Workshop }) => [
        AppLayout,
        { title: props.workshop.name },
    ],
});
const props = defineProps<{ workshop: Workshop }>();

const selectedDate = ref(new Date());
const sessions = ref<Record<number, WorkshopSession[]>>();
const selectedDateSessions = computed<WorkshopSession[]>(
    () => sessions.value?.[selectedDate.value.getDate()] ?? [],
);

const monthKey = computed(
    () =>
        `${selectedDate.value.getFullYear()}-${selectedDate.value.getMonth()}`,
);

watch(
    monthKey,
    () => {
        fillSessions(selectedDate.value);
    },
    { immediate: true },
);

onMounted(() => fillSessions(selectedDate.value));

async function fillSessions(date: Date) {
    sessions.value = {};

    const items = await WorkshopRepository.filterWorkshopSessions(
        props.workshop,
        date,
    );

    for (const [key, value] of Object.entries(items)) {
        const date = new Date(key);

        sessions.value = { [date.getDate()]: value, ...sessions.value };
    }
}

function handleChangeDate(newDate: Date) {
    selectedDate.value = newDate;
}
</script>

<style scoped></style>
