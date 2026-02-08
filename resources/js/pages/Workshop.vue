<template>
    <AppLayout :title="workshop.name">
        <div class="container my-5">
            <div class="row mb-4">

                <div class="col-md-6">
                    <Link class="btn btn-outline-primary mb-3" :href="route('workshops')">
                        ← Retour à la boutique
                    </Link>

                    <!-- Carrousel principal -->
                    <div id="workshopCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div v-for="(img, index) in workshop.images" :key="index"
                                 :class="['carousel-item', { active: index === 0 }]">
                                <AppImage :src="`https://back.windigoprint.com/storage/${img}`" class="d-block w-100 rounded" />
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#workshopCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#workshopCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                    <!-- Miniatures -->
                    <div v-if="workshop.images?.length > 1" ref="thumbnailsContainer"
                         class="mt-3 d-flex flex-wrap gap-2 justify-content-center">
                        <AppImage
                            v-for="(img, index) in workshop.images"
                            :key="'thumb-' + index"
                            :src="`https://back.windigoprint.com/storage/${img}`" class="thumbnail"
                            style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;" :data-bs-target="'#workshopCarousel'"
                            :data-bs-slide-to="index"
                        />
                    </div>

                    <div v-else class="border rounded p-3 text-center text-muted">Aucune image disponible</div>
                </div>

                <div class="col-md-6">
                    <h2>{{ workshop.name }}</h2>
                    <h5 class="text-muted">{{ workshop.type }}</h5>
                    <p><strong>Prix :</strong> {{ workshop.price }} €</p>
                    <p><strong>Durée :</strong> {{ workshop.duration }} min</p>
                    <p><strong>Âge minimum :</strong> {{ workshop.age }} ans</p>
                    <p class="mt-3">{{ workshop.description }}</p>
                </div>
            </div>

            <h4 class="mt-5">Sessions disponibles</h4>
            <!-- Sessions -->
            <div v-if="workshop.workshop_sessions?.length" class="mt-auto">
                <h6>Sessions :</h6>
                <ul class="list-group list-group-flush">
                    <li v-for="session in workshop.workshop_sessions" :key="session.id"
                        class="list-group-item d-flex justify-content-between align-items-center">
                        {{ formatDate(session.date) }} - N°{{ session.session_number }}
                        <span class="badge bg-primary rounded-pill">{{ session.remaining_places }} places</span>
                        <button @click="handleBooking(session.id)"> Reserver </button>
                    </li>
                </ul>
            </div>
            <p v-else>Aucune session prévue pour le moment.</p>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import {Workshop} from "@/models/Workshop";
import AppImage from "@/components/AppImage.vue";
import { Link } from "@inertiajs/vue3";

defineProps<{ workshop: Workshop }>()
</script>

<style scoped>

</style>
