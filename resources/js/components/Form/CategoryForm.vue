<template>
    <form @submit.prevent="submit" class="flex-column flex gap-2">
        <AppInput
            v-model="form.name"
            :error="form.errors.name"
            label="Nom"
            placeholder="Nom"
            type="text"
            class="form-control"
        />
        <div class="flex gap-2">
            <button
                type="submit"
                class="rounded bg-blue-600 px-4 py-2 text-white"
            >
                {{ form.id ? 'Mettre à jour' : 'Créer' }}
            </button>
            <button
                type="button"
                @click="resetForm"
                class="rounded bg-gray-300 px-4 py-2"
            >
                Annuler
            </button>
        </div>
    </form>
</template>

<script setup lang="ts">
import { store } from '@/actions/App/Http/Controllers/Auth/CategoryController';
import AppInput from '@/components/Global/AppInput.vue';
import { Category } from '@/models';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{ form?: Category }>();

const emits = defineEmits<{
    (e: 'reset');
}>();

const form = useForm<Category>(
    store().method,
    store().url,
    props.form ?? {
        name: '',
    },
);

function submit() {
    form.submit({
        onSuccess: () => {
            emits('reset');
        },
    });
}

function resetForm() {
    form.reset();
    emits('reset');
}
</script>

<style scoped></style>
