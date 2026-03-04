<template>
    <AppLayout title="Aterliers de sérigraphie">
        <div class="container my-5">
            <h2 class="mb-4 text-center">Nos Ateliers</h2>
            <div class="row g-4">
                <div
                    v-for="workshop in workshops"
                    :key="workshop.id"
                    class="col-12 col-md-6 col-lg-4"
                >
                    <Link :href="route('workshop', { id: workshop.id })">
                        <div class="card shadow-sm">
                            <div class="card--header">
                                <AppImage
                                    :src="workshop.first_image_url"
                                    :alt="workshop.name"
                                    class="card-header--image"
                                    imgFit="fill"
                                />
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ workshop.name }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ workshop.type }}</h6>
                                <p class="card-text mb-1"><strong>Prix :</strong> {{ workshop.price }} €</p>
                                <p class="card-text mb-2"><strong>Durée :</strong> {{ workshop.duration }} min</p>
                                <p class="card-text mb-2"><strong>Âge minimum :</strong> {{ workshop.age }} ans</p>

                                <button class="btn btn-primary mt-3 w-100">
                                    Voir détails & Réserver
                                </button>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import {Head, Link} from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import AppImage from "@/components/AppImage.vue";
import {Workshop} from "@/models/Workshop";

defineProps<{ workshops: Workshop[] }>()
</script>

<style scoped>
a {
    text-decoration: none;
}
.card {
    border-radius: 12px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

.card--header {
    height: 180px;
    border-radius: 8px;
    overflow: hidden;
}

.card--header > div {
    height: inherit;
}

.card-header--image {
    height: inherit;
    object-fit: contain;
}
</style>
