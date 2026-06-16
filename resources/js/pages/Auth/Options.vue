<template>
    <AppLayoutAdmin>
        <div class="container my-5">
            <div class="flex gap-2">
                <h2>Gestion des Options</h2>
                <button @click.prevent="newOption" class="btn btn-success">
                    Nouvelle option
                </button>
            </div>

            <div v-if="showForm" class="card mb-4 p-3">
                <OptionForm
                    :form="currentOption"
                    :key="currentOption ? currentOption.id : 'new-option'"
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
                    <tr
                        v-for="option in options.items"
                        :key="option.id"
                        class="align-middle"
                    >
                        <td>{{ option.id }}</td>
                        <td>{{ option.name }}</td>
                        <td class="flex gap-2">
                            <button
                                @click.prevent="edit(option)"
                                class="rounded bg-yellow-400 px-2 py-1"
                            >
                                ✏️
                            </button>
                            <button
                                @click.prevent="deleteOptions(option)"
                                class="rounded bg-red-500 px-2 py-1 text-white"
                            >
                                🗑️
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <AppPagination
                :totalPage="options.pagination.totalPage"
                :currentPage="options.pagination.currentPage"
                :path="options.pagination.path"
            />
        </div>
    </AppLayoutAdmin>
</template>

<script setup lang="ts">
import AppPagination from '@/components/AppPagination.vue';
import OptionForm from '@/components/Form/OptionForm.vue';
import AppLayoutAdmin from '@/layouts/AppLayoutAdmin.vue';
import { Option, ResourcePaginated } from '@/models';
import OptionRepository from '@/services/OptionRepository';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const { options } = defineProps<{ options: ResourcePaginated<Option> }>();

const showForm = ref(false);
const currentOption = ref<Option | undefined>();

function newOption() {
    currentOption.value = undefined;
    showForm.value = true;
}

function edit(option: Option) {
    currentOption.value = option;
    showForm.value = true;
}

async function deleteOptions(option: Option) {
    await OptionRepository.deleteOption(option);

    router.reload({
        only: ['options'],
        onSuccess: () => {
            router.flash('notification', {
                message: 'Option supprimée avec succès',
                type: 'success',
            });
        },
    });
}
</script>

<style scoped></style>
