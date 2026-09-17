<template>
    <div class="container">
        <Link class="btn btn-outline-primary mb-3" :href="route('workshops')">
            ← Retour à la boutique
        </Link>
        <div class="row">
            <div class="col-md-6">
                <CarouselWithMiniatures
                    :images="workshop.images"
                    :selectedImageUrl="workshop.highlighted_image?.url"
                />
            </div>
            <div class="col-md-6">
                <h2>{{ workshop.name }}</h2>
                <h5 class="text-muted">{{ workshop.type }}</h5>
                <p><strong>Prix :</strong> {{ workshop.price }} €</p>
                <p><strong>Durée :</strong> {{ workshop.duration }} min</p>
                <p><strong>Âge minimum :</strong> {{ workshop.age }} ans</p>
                <p class="mt-3">{{ workshop.description }}</p>
                <p class="divide-red-400"></p>
            </div>
        </div>
        <div v-if="workshop.workshop_sessions?.length" class="mt-2">
<!--            <h6>Sessions :</h6>-->
<!--            <ul class="list-group list-group-flush">-->
<!--                <li-->
<!--                    v-for="session in workshop.workshop_sessions"-->
<!--                    :key="session.id"-->
<!--                    class="list-group-item d-flex justify-content-between align-items-center"-->
<!--                >-->
<!--                    {{ formatDate(session.date) }} - N°{{-->
<!--                        session.session_number-->
<!--                    }}-->
<!--                    <span class="badge rounded-pill bg-primary"-->
<!--                        >{{ session.remaining_places }} places</span-->
<!--                    >-->
<!--                    <button @click="handleBooking(session.id)">Reserver</button>-->
<!--                </li>-->
<!--            </ul>-->
        </div>
        <AppEmptyList v-else class="mt-2">
            <template #content>
                Aucune session prévue pour le moment.
            </template>
        </AppEmptyList>
    </div>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Workshop } from '@/models/Workshop';
import { Link } from '@inertiajs/vue3';
import CarouselWithMiniatures from '@/components/Carousel/CarouselWithMiniatures.vue';
import AppEmptyList from '@/components/Global/AppEmptyList.vue';

defineOptions({
    layout: (props: { workshop: Workshop }) => [
        AppLayout,
        { title: props.workshop.name },
    ],
});
defineProps<{ workshop: Workshop }>();
</script>

<style scoped></style>
