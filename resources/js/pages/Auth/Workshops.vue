<template>
    <div class="container my-5">
        <div class="flex gap-2">
            <h2>Gestion des Ateliers</h2>
            <AppButton
                ignoreStyle
                class="btn btn-success mb-3"
                @click="newWorkshop"
            >
                Ajouter un atelier
            </AppButton>
        </div>

        <div v-if="showForm" class="card mb-4 p-3">
            <WorkshopForm
                :types="types"
                :workshop="currentWorkshop"
                :key="currentWorkshop ? currentWorkshop.id : 'new-workshop'"
                @close="showForm = false"
            />
        </div>

        <!-- Table des ateliers -->
        <table class="table-striped table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Prix</th>
                    <th>Durée</th>
                    <th>Age</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="workshop in workshops.items"
                    :key="workshop.id"
                    class="align-middle"
                >
                    <td>{{ workshop.name }}</td>
                    <td>{{ workshop.type }}</td>
                    <td>{{ workshop.price }} €</td>
                    <td>{{ workshop.duration }} min</td>
                    <td>{{ workshop.age }} ans</td>

                    <!-- Image principale -->
                    <td>
                        <AppImage
                            :url="workshop.highlighted_image?.url"
                            :alt="workshop.name"
                            imgCssClass="table-image img-cover-50"
                        />
                    </td>

                    <!-- Description tronquée -->
                    <td>
                        {{
                            workshop.description
                                ? workshop.description.length > 100
                                    ? workshop.description.substring(0, 100) +
                                      '...'
                                    : workshop.description
                                : 'Aucune description'
                        }}
                    </td>
                    <td>
                        <div class="flex gap-2">
                            <AppButton
                                ignoreStyle
                                @click="editWorkshop(workshop)"
                                class="rounded bg-yellow-400 px-2 py-1"
                            >
                                ✏️
                            </AppButton>
                            <AppButton
                                ignoreStyle
                                @click="deleteWorkshop(workshop)"
                                class="rounded bg-red-500 px-2 py-1 text-white"
                            >
                                🗑️
                            </AppButton>
                            <Link
                                :to="{
                                    name: 'admin.workshop.sessions',
                                    params: { id: workshop.id },
                                }"
                                class="rounded bg-blue-500 px-2 py-1 text-white !no-underline"
                            >
                                📅
                            </Link>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <AppPagination
            v-if="workshops.pagination.totalPage > 1"
            :totalPage="workshops.pagination.totalPage"
            :currentPage="workshops.pagination.currentPage"
            :path="workshops.pagination.path"
        />
    </div>
</template>

<script setup lang="ts">
import AppImage from '@/components/AppImage.vue';
import AppPagination from '@/components/AppPagination.vue';
import AppLayoutAdmin from '@/layouts/AppLayoutAdmin.vue';
import { ResourcePaginated, Workshop } from '@/models';
import { Link, router } from '@inertiajs/vue3';
import WorkshopForm from '@/components/Form/WorkshopForm.vue';
import { ref } from 'vue';
import AppButton from '@/components/Global/AppButton.vue';
import WorkshopRepository from '@/services/WorkshopRepository';

defineOptions({
    layout: [AppLayoutAdmin, { title: 'Administration des ateliers'}],
});
defineProps<{ workshops: ResourcePaginated<Workshop>; types: string[] }>();

const showForm = ref(false);
const currentWorkshop = ref<Workshop>();

function newWorkshop() {
    currentWorkshop.value = undefined;

    showForm.value = true;
}

function editWorkshop(workshop: Workshop) {
    currentWorkshop.value = workshop;

    showForm.value = true;
}
async function deleteWorkshop(workshop: Workshop) {
    await WorkshopRepository.delete(workshop);

    router.reload({
        only: ['workshops'],
        onSuccess: () => {
            router.flash('notification', {
                message: 'Atelier supprimé',
                type: 'success',
            });
        },
    });
}
</script>

<style scoped>
.table-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
}
</style>
