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

    <div class="flex gap-4 my-3">
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

    <div class="flex justify-end mb-2">
      <input type="checkbox" v-model="formData.archived" class="form-check-input mx-2" id="archived" />
      <label class="form-check-label" for="archived">Archivé</label>
    </div>

    <!-- Picture -->
    <ul class="flex gap-1 items-center justify-center">
      <li>
        <AppPreviewImage class="w-[150px] h-[150px]" @image:loaded="(image) => loadPreviewImage(image)" />
      </li>
      <li v-for="image in images">
        <AppImage :url="image" class="w-[150px] h-[150px] object-fill" />
        <p class="flex">
          <button class="flex flex-1 justify-center bg-blue-500 hover:bg-blue-700 text-white p-2">
            <StarIcon class="size-4" />
          </button>
          <button class="flex flex-1 justify-center bg-red-500 hover:bg-red-700 text-white p-2">
            <XMarkIcon class="size-4" />
          </button>
        </p>
      </li>
    </ul>

    <button class="btn btn-primary me-2" type="submit">Enregistrer</button>
    <button class="btn btn-secondary" @click="$emit('close')">Annuler</button>
  </form>
</template>

<script setup lang="ts">
import {Category, Option, Product, ProductForm} from "@/models";
import AppInput from "@/components/Global/AppInput.vue";
import {useForm} from "@inertiajs/vue3";
import { store } from '@/actions/App/Http/Controllers/Auth/ProductController'
import AppTextarea from "@/components/Global/AppTextarea.vue";
import AppSelect from "@/components/Global/AppSelect.vue";
import AppImage from "@/components/AppImage.vue";
import AppPreviewImage from "@/components/AppPreviewImage.vue";
import {ref} from "vue";
import StarIcon from "@/components/Icon/StarIcon.vue";
import XMarkIcon from "@/components/Icon/XMarkIcon.vue";

const props = defineProps<{ options: Option[], categories: Category[], product?: Product}>()

const emits = defineEmits<{
  (e: 'close')
}>()

const formData = useForm<ProductForm>(
    store().method,
    store().url,
    {
    id: props.product?.id ?? 0,
    name: props.product?.name ?? '',
    price: props.product?.price ?? 0,
    stock: props.product?.stock ?? 0,
    description: props.product?.description ?? '',
    archived: props.product?.archived ?? false,
    pictures: [],
    category_id: props.product?.category?.id ?? 0,
    option_id: props.product?.option?.id ?? 0,
  }
)

const images = ref(props.product.media.map(image => image.original_url))

function loadPreviewImage(image: File) {
  images.value.push(URL.createObjectURL(image))
  formData.pictures.push(image)
}

function submit()
{
  formData.submit({
    onSuccess: () => { emits('close') }
  });

}
</script>

<style>
.overlayContent {
  position: absolute;
  display: none;
}

.overlayContainer:hover .overlayContent {
  display: flex;
  width: inherit;
  justify-content: space-between;
}
</style>