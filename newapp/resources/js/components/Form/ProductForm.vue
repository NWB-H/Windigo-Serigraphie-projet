<template>
  <form @submit.prevent="form.post(route('admin.store'))">
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
    <textarea v-model="form.description" class="form-control mb-2" placeholder="Description"></textarea>

    <div class="form-check mb-2">
      <input type="checkbox" v-model="form.archived" class="form-check-input" id="archived" />
      <label class="form-check-label" for="archived">Archivé</label>
    </div>

    <select v-model="form.category" class="form-select mb-2">
      <option disabled value="">-- Choisir une catégorie --</option>
      <option v-for="c in categories" :key="c.id" :value="c">{{ c.name }}</option>
    </select>

    <select v-model="form.option" class="form-select mb-2">
      <option disabled value="">-- Choisir une option --</option>
      <option v-for="o in options" :key="o.id" :value="o">{{ o.name }}</option>
    </select>

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
import {Category, Option, Product} from "@/models";
import AppInput from "@/components/Global/AppInput.vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps<{ options: Option[], categories: Category[], form?: Product}>()

defineEmits<{
  (e: 'close')
}>()

const form = useForm<Product>(
    'post',
    '/admin/products',
    props.form ?? {
    id: 0,
    name: '',
    price: 0,
    stock: 0,
    description: '',
    archived: false,
    picture: '',
    category: undefined,
    option: undefined,
    picture_url: undefined,
    images: undefined
  }
)
</script>
