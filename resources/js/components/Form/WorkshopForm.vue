<template>
    <form @submit.prevent="saveWorkshop">
        <AppInput
            v-model="formData.name"
            :error="formData.errors.name"
            type="text"
            placeholder="Name"
            id="name"
            inputContainerClass="bg-white"
        />
        <div class="flex gap-1">
            <AppSelect
                v-model="formData.type"
                :error="formData.errors.type"
                :items="types"
                placeholder="Type"
                class="flex-1"
            />
            <AppInput
                v-model="formData.price"
                :error="formData.errors.price"
                type="number"
                step="0.01"
                placeholder="Prix"
                id="price"
                containerClass="flex-1"
                inputContainerClass="bg-white"
            />
            <AppInput
                v-model="formData.duration"
                :error="formData.errors.duration"
                type="number"
                id="duration"
                placeholder="Durée (en minutes)"
                containerClass="flex-1"
                inputContainerClass="bg-white"
            />
            <AppInput
                v-model="formData.age"
                :error="formData.errors.age"
                type="number"
                id="age"
                placeholder="Age minimum"
                containerClass="flex-1"
                inputContainerClass="bg-white"
            />
        </div>

        <AppTextarea
            v-model="formData.description"
            :error="formData.errors.description"
            id="description"
            placeholder="Description"
        />

        <div class="flex gap-2">
            <AppButton>
                {{ formData.id !== 0 ? 'Mettre à jour' : 'Créer' }}
            </AppButton>
            <AppButton type="cancel" @click="$emit('close')">Annuler</AppButton>
        </div>
    </form>
</template>

<script setup lang="ts">
import { Workshop, WorkshopForm } from '@/models';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AppInput from '@/components/Global/AppInput.vue';
import AppTextarea from '@/components/Global/AppTextarea.vue';
import AppButton from '@/components/Global/AppButton.vue';
import { store } from '@/actions/App/Http/Controllers/Auth/WorkshopController';
import AppSelect from '@/components/Global/AppSelect.vue';

const props = defineProps<{
    workshop?: Workshop;
    types: string[];
}>();

const emits = defineEmits<{ (e: 'close'): void }>();

const workshop = ref(
    props.workshop ?? {
        id: 0,
        name: '',
        type: '',
        price: 0,
        duration: 0,
        age: 0,
        description: '',
    },
);

const formData = useForm<WorkshopForm>(store().method, store().url, {
    id: workshop.value.id,
    name: workshop.value.name,
    type: workshop.value.type,
    price: workshop.value.price,
    duration: workshop.value.duration,
    age: workshop.value.age,
    description: workshop.value.description,
});

function saveWorkshop() {
    formData.submit({
        onSuccess: () => {
            emits('close')
        },
    });
}
</script>

<style scoped></style>
