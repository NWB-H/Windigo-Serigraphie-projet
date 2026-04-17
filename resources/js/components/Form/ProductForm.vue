<template>
    <form @submit.prevent="submit">
        <AppInput
            v-model="formData.name"
            :error="formData.errors.name"
            type="text"
            class="form-control"
            placeholder="Nom"
            id="name"
        />
        <div class="flex gap-4">
            <AppInput
                v-model.number="formData.price"
                :error="formData.errors.price"
                type="number"
                containerClass="flex-1"
                class="form-control"
                placeholder="Prix (1-50)"
                id="price"
            />
            <AppInput
                v-model.number="formData.stock"
                :error="formData.errors.stock"
                type="number"
                containerClass="flex-1"
                class="form-control"
                placeholder="Stock"
                id="stock"
            />
        </div>

        <AppTextarea
            v-model="formData.description"
            :error="formData.errors.description"
            class="form-control my-3"
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
                    @image:loaded="(image) => loadPreviewImage(image)"
                />
            </li>
            <ProductFormCarousel
                :images="images"
                @delete="(index) => deleteImage(index)"
            />
        </ul>

        <button class="btn btn-primary me-2" type="submit">Enregistrer</button>
        <button class="btn btn-secondary" @click="$emit('close')">
            Annuler
        </button>
    </form>
</template>

<script setup lang="ts">
import { Category, Image, Option, Product, ProductForm } from '@/models';
import AppInput from '@/components/Global/AppInput.vue';
import { useForm } from '@inertiajs/vue3';
import { store } from '@/actions/App/Http/Controllers/Auth/ProductController';
import AppTextarea from '@/components/Global/AppTextarea.vue';
import AppSelect from '@/components/Global/AppSelect.vue';
import AppPreviewImage from '@/components/AppPreviewImage.vue';
import { ref } from 'vue';
import ProductFormCarousel from '@/components/ProductFormCarousel.vue';
import ProductRepository from '@/services/ProductRepository';

const props = defineProps<{
    options: Option[];
    categories: Category[];
    product: Product;
}>();

const emits = defineEmits<{
    (e: 'close'): void;
}>();

const formData = useForm<ProductForm>(store().method, store().url, {
    id: props.product?.id ?? 0,
    name: props.product?.name ?? '',
    price: props.product?.price ?? 0,
    stock: props.product?.stock ?? 0,
    description: props.product?.description ?? '',
    archived: props.product?.archived ?? false,
    pictures: [],
    category_id: props.product?.category?.id ?? 0,
    option_id: props.product?.option?.id ?? 0,
});

const images = ref<Image[]>(props.product.images);

function loadPreviewImage(image: File) {
    images.value.push({ url: URL.createObjectURL(image), isHighlighted: false } as Image);
    formData.pictures.push(image);
}

function submit() {
    formData.submit({
        onSuccess: () => {
            emits('close');
        },
    });
}

function deleteImage(index: number) {
    ProductRepository
        .deleteMedia(props.product, images.value[index])
        .then(() => {
            images.value.splice(index, 1);
        })
}
</script>

<style></style>
