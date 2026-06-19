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
        <ul class="flex items-center justify-center gap-1">
            <li>
                <AppPreviewImage
                    class="size-[150px]"
                    @image:loaded="loadPreviewImage"
                />
            </li>
            <AppFormCarousel
                :images="workshop.images"
                @star="toggleStar"
                @delete="deleteImage"
            />
        </ul>

        <div class="flex gap-2">
            <AppButton>
                {{ formData.id !== 0 ? 'Mettre à jour' : 'Créer' }}
            </AppButton>
            <AppButton type="cancel" @click="$emit('close')">Annuler</AppButton>
        </div>
    </form>
</template>

<script setup lang="ts">
import { Workshop, WorkshopForm, Image } from '@/models';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AppInput from '@/components/Global/AppInput.vue';
import AppTextarea from '@/components/Global/AppTextarea.vue';
import AppButton from '@/components/Global/AppButton.vue';
import { store } from '@/actions/App/Http/Controllers/Auth/WorkshopController';
import AppSelect from '@/components/Global/AppSelect.vue';
import AppPreviewImage from '@/components/AppPreviewImage.vue';
import AppFormCarousel from '@/components/AppFormCarousel.vue';
import WorkshopRepository from '@/services/WorkshopRepository';

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
        images: [],
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
    images: [],
});

function loadPreviewImage(image: File) {
    workshop.value.images.push({
        url: URL.createObjectURL(image),
        isHighlighted: false,
    } as Image);
    formData.images.push({ file: image, isHighlighted: false });
}

function saveWorkshop() {
    formData.submit({
        onSuccess: () => {
            emits('close');
        },
    });
}

async function deleteImage(index: number) {
    const image = workshop.value.images[index];

    if (!image) {
        return;
    }

    await WorkshopRepository.deleteImage(workshop.value, image);

    workshop.value.images.splice(index, 1);
}

async function toggleStar(index: number) {
    const image = workshop.value.images[index];

    if (!image) {
        return;
    }

    await WorkshopRepository.setHighlighted(workshop.value, image);

    workshop.value.images.map((image, i) => {
        image.isHighlighted = i === index;
    })

    formData.images.map((image, i) => {
        const searchIndex =
            index - (workshop.value.images.length - formData.images.length);

        image.isHighlighted = searchIndex === i;
    })
}
</script>

<style scoped></style>
