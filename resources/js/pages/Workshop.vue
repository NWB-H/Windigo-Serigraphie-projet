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
                <p class="divide-red-400"></p>
                <AppMonthSelector :date="date" @click="(value) => date = value" />
            </div>
            <div class="col-span-5">
                <WorkshopCalendar :date="date" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Workshop } from '@/models/Workshop';
import { Link } from '@inertiajs/vue3';
import CarouselWithMiniatures from '@/components/Carousel/CarouselWithMiniatures.vue';
import AppMonthSelector from '@/components/Global/AppMonthSelector.vue';
import WorkshopCalendar from '@/components/WorkshopSession/WorkshopCalendar.vue';
import { ref } from 'vue';

defineOptions({
    layout: (props: { workshop: Workshop }) => [
        AppLayout,
        { title: props.workshop.name },
    ],
});
defineProps<{ workshop: Workshop }>();

const date = ref(new Date())
</script>

<style scoped></style>
