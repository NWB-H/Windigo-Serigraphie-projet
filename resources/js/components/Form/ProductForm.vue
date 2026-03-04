<template>
  <form @submit.prevent="submit">
    <AppInput
        v-model="form.name"
        :error="form.errors.name"
        type="text"
        class="form-control"
        placeholder="Nom"
        id="name"
    />
    <AppInput
        v-model.number="form.price"
        :error="form.errors.price"
        type="number"
        class="form-control"
        placeholder="Prix (1-50)"
        id="price"
    />
    <AppInput
      v-model.number="form.stock"
      :error="form.errors.stock"
      type="number"
      class="form-control"
      placeholder="Stock"
      id="stock"
    />

    <AppTextarea
      v-model="form.description"
      :error="form.errors.description"
      class="form-control mb-2"
      placeholder="Description"
    />

    <div class="form-check mb-2">
      <input type="checkbox" v-model="form.archived" class="form-check-input" id="archived" />
      <label class="form-check-label" for="archived">Archivé</label>
    </div>

    <AppSelect
      v-model="form.category_id"
      placeholder="Choisir une catégorie"
      :items="categories"
      value="id"
      label="name"
      :error="form.errors.category_id"
    />

    <AppSelect
        v-model="form.option_id"
        placeholder="Choisir une option"
        :items="options"
        value="id"
        label="name"
        :error="form.errors.option_id"
    />

    <!-- Picture -->
    <input
        type="file"
        class="form-control mb-2"
        @change="e => form.picture = (e.target as HTMLInputElement).files?.[0] || null"
    />
    <div
        v-if="form?.picture"
        class="mb-2 d-flex align-items-center"
    >
      <img
          :src="typeof editingProduct.picture === 'string' ? editingProduct.picture : ''"
          alt="Aperçu"
          style="width: 100px; height: 100px; object-fit: cover; margin-right: 10px;" />
      <button type="button" class="btn btn-sm btn-danger">
        Supprimer l'image
      </button>
    </div>

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

const props = defineProps<{ options: Option[], categories: Category[], form?: Product}>()

const emits = defineEmits<{
  (e: 'close')
}>()

const form = useForm<ProductForm>(
    store().method,
    store().url,
    props.form ?? {
    id: 0,
    name: '',
    price: 0,
    stock: 0,
    description: '',
    archived: false,
    picture: '',
    category_id: 0,
    option_id: 0,
    picture_url: undefined,
    images: undefined
  }
)

function submit()
{
  form.submit({
    onSuccess: () => { emits('close') }
  });

}
</script>
