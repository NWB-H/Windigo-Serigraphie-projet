<template>
    <AppLayoutAdmin title="Administration catégories">
        <div class="container my-5">
            <div class="flex gap-2">
                <h2>Gestion des Catégories</h2>
                <button @click.prevent="newCategory" class="btn btn-success">
                    Nouvelle catégorie
                </button>
            </div>

            <div v-if="showForm" class="card mb-4 p-3">
                <CategoryForm
                    :form="currentCategory"
                    :key="currentCategory ? currentCategory.id : 'new-category'"
                    @reset="showForm = false"
                />
            </div>

            <table class="table-striped table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="category in categories.items" :key="category.id">
                        <td>{{ category.id }}</td>
                        <td>{{ category.name }}</td>
                        <td class="flex gap-2">
                            <button
                                @click.prevent="edit(category)"
                                class="rounded bg-yellow-400 px-2 py-1"
                            >
                                ✏️
                            </button>
                            <button
                                @click.prevent="deleteCategory(category)"
                                class="rounded bg-red-500 px-2 py-1 text-white"
                            >
                                🗑️
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <AppPagination
                :path="categories.pagination.path"
                :totalPage="categories.pagination.totalPage"
                :currentPage="categories.pagination.currentPage"
            />
        </div>
    </AppLayoutAdmin>
</template>

<script setup lang="ts">
import AppPagination from '@/components/AppPagination.vue';
import CategoryForm from '@/components/Form/CategoryForm.vue';
import AppLayoutAdmin from '@/layouts/AppLayoutAdmin.vue';
import { Category, ResourcePaginated } from '@/models';
import CategoryRepository from '@/services/CategoryRepository';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const { categories } = defineProps<{
    categories: ResourcePaginated<Category>;
}>();

const showForm = ref(false);

const currentCategory = ref<Category | undefined>();

function newCategory() {
    currentCategory.value = undefined;
    showForm.value = true;
}

function edit(category: Category) {
    currentCategory.value = category;
    showForm.value = true;
}

async function deleteCategory(category: Category) {
    await CategoryRepository.deleteCategory(category);

    router.reload({
        only: ['categories'],
        onSuccess: () => {
            router.flash('notification', {
                message: 'Categorie supprimé avec succès',
                type: 'success',
            });
        },
    });
}
</script>

<style scoped></style>
