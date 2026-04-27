<template>
    <AppLayoutAdmin>
        <div class="p-4">
            <h2 class="mb-4 text-xl font-semibold">Gestion des Ateliers</h2>

            <!-- Table des ateliers -->
            <table class="mb-6 w-full border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-2 py-1">ID</th>
                        <th class="border px-2 py-1">Nom</th>
                        <th class="border px-2 py-1">Type</th>
                        <th class="border px-2 py-1">Prix</th>
                        <th class="border px-2 py-1">Durée</th>
                        <th class="border px-2 py-1">Age</th>
                        <th class="border px-2 py-1">Image</th>
                        <th class="border px-2 py-1">Description</th>
                        <th class="border px-2 py-1">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="workshop in workshops.items" :key="workshop.id">
                        <td class="border px-2 py-1">{{ workshop.id }}</td>
                        <td class="border px-2 py-1">{{ workshop.name }}</td>
                        <td class="border px-2 py-1">{{ workshop.type }}</td>
                        <td class="border px-2 py-1">{{ workshop.price }} €</td>
                        <td class="border px-2 py-1">
                            {{ workshop.duration }} min
                        </td>
                        <td class="border px-2 py-1">{{ workshop.age }} ans</td>

                        <!-- Image principale -->
                        <td class="border px-2 py-1">
                            <AppImage
                                :url="workshop.first_image_url"
                                :alt="workshop.name"
                                imgCssClass="table-image img-cover-50"
                            />
                        </td>

                        <!-- Description tronquée -->
                        <td class="border px-2 py-1">
                            {{
                                workshop.description
                                    ? workshop.description.length > 100
                                        ? workshop.description.substring(
                                              0,
                                              100,
                                          ) + '...'
                                        : workshop.description
                                    : 'Aucune description'
                            }}
                        </td>
                        <td class="space-x-2 border px-2 py-1">
                            <button
                                @click="editWorkshop()"
                                class="rounded bg-yellow-400 px-2 py-1"
                            >
                                ✏️
                            </button>
                            <button
                                @click="deleteWorkshop()"
                                class="rounded bg-red-500 px-2 py-1 text-white"
                            >
                                🗑️
                            </button>
                            <Link
                                :to="{
                                    name: 'admin.workshop.sessions',
                                    params: { id: workshop.id },
                                }"
                                class="rounded bg-blue-500 px-2 py-1 text-white"
                            >
                                📅 Sessions
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <AppPagination
                :totalPage="workshops.pagination.totalPage"
                :currentPage="workshops.pagination.currentPage"
                :path="workshops.pagination.path"
            />
        </div>
    </AppLayoutAdmin>
</template>

<script setup lang="ts">
import AppImage from '@/components/AppImage.vue';
import AppPagination from '@/components/AppPagination.vue';
import AppLayoutAdmin from '@/layouts/AppLayoutAdmin.vue';
import { ResourcePaginated, Workshop } from '@/models';
import { Link } from '@inertiajs/vue3';

defineProps<{ workshops: ResourcePaginated<Workshop> }>();

function editWorkshop() {}
function deleteWorkshop() {}
</script>

<style scoped>
.table-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
}
</style>
