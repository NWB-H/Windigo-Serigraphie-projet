<template>
    <form @submit.prevent="submit">
        <AppInput
            v-model="formData.name"
            :error="formData.errors.name"
            type="text"
            class="form-control"
            placeholder="Nom"
            id="name"
            inputContainerClass="bg-white"
        />
        <div class="flex gap-4">
            <AppInput
                v-model.number="formData.price"
                :error="formData.errors.price"
                type="number"
                step="0.01"
                containerClass="flex-1"
                class="form-control"
                placeholder="Prix (1-50)"
                id="price"
                inputContainerClass="bg-white"
            />
            <AppInput
                v-model.number="formData.stock"
                :error="formData.errors.stock"
                type="number"
                containerClass="flex-1"
                class="form-control"
                placeholder="Stock"
                id="stock"
                inputContainerClass="bg-white"
            />
        </div>

        <AppTextarea
            v-model="formData.description"
            :error="formData.errors.description"
            id="description"
            placeholder="Description"
        />

        <div class="my-3 flex gap-4">
            <AppSelect
                v-model="formData.category_id"
                placeholder="Choisir une catégorie"
                :items="categories"
                value="id"
                label="name"
                class="flex-1"
                :error="formData.errors.category_id"
            />

            <AppSelect
                v-model="formData.option_id"
                placeholder="Choisir une option"
                :items="options"
                value="id"
                label="name"
                class="flex-1"
                :error="formData.errors.option_id"
            />
        </div>

        <div class="mb-2 flex justify-end">
            <input
                type="checkbox"
                v-model="formData.archived"
                class="form-check-input mx-2"
                id="archived"
            />
            <label class="form-check-label" for="archived">Archivé</label>
        </div>

        <!-- Picture -->
        <ul class="flex items-center justify-center gap-1">
            <li>
                <AppPreviewImage
                    class="h-[150px] w-[150px]"
                    @image:loaded="loadPreviewImage"
                />
            </li>
            <AppFormCarousel
                :images="product.images"
                @delete="deleteImage"
                @star="toggleStar"
            />
        </ul>

        <button class="btn btn-primary me-2" type="submit">Enregistrer</button>
        <button class="btn btn-secondary" @click="$emit('close')">
            Annuler
        </button>
    </form>
</template>

<script setup lang="ts">
import { store } from '@/actions/App/Http/Controllers/Auth/ProductController';
import AppPreviewImage from '@/components/AppPreviewImage.vue';
import AppInput from '@/components/Global/AppInput.vue';
import AppSelect from '@/components/Global/AppSelect.vue';
import AppTextarea from '@/components/Global/AppTextarea.vue';
import AppFormCarousel from '@/components/AppFormCarousel.vue';
import { Category, Image, Option, Product, ProductForm } from '@/models';
import ProductRepository from '@/services/ProductRepository';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    options: Option[];
    categories: Category[];
    product?: Product;
}>();

const emits = defineEmits<{
    (e: 'close'): void;
}>();

const product = ref(
    props.product ?? {
        id: 0,
        name: '',
        price: 0,
        stock: 0,
        description: '',
        archived: false,
        images: [],
        category: { id: 0, name: '' },
        option: { id: 0, name: '' },
    },
);

const formData = useForm<ProductForm>(store().method, store().url, {
    id: product.value.id,
    name: product.value.name,
    price: product.value.price,
    stock: product.value.stock,
    description: product.value.description,
    archived: product.value.archived,
    images: [],
    category_id: product.value.category?.id ?? 0,
    option_id: product.value.option?.id ?? 0,
});

function loadPreviewImage(image: File) {
    product.value.images.push({
        url: URL.createObjectURL(image),
        isHighlighted: false,
    } as Image);
    formData.images.push({ file: image, isHighlighted: false });
}

function submit() {
    formData.submit({
        onSuccess: () => {
            emits('close');
        },
    });
}

async function deleteImage(index: number) {
    if (product.value.images[index].id) {
        await ProductRepository.deleteMedia(
            product.value,
            product.value.images[index],
        );
    }

    product.value.images.splice(index, 1);
}

async function toggleStar(index: number) {
    if (product.value.images[index].id) {
        await ProductRepository.setHighlighted(
            product.value,
            product.value.images[index],
        );
    }

    product.value.images.map((image, i) => {
        image.isHighlighted = i === index;
    });

    formData.images.map((image, i) => {
        const searchIndex =
            index - (product.value.images.length - formData.images.length);

        image.isHighlighted = searchIndex === i;
    });
}
</script>

<style></style>
