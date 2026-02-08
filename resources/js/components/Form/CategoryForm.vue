<template>
  <form @submit.prevent="submit" class="flex flex-column gap-2">
    <AppInput
        v-model="form.name"
        :error="form.errors.name"
        label="Nom"
        placeholder="Nom"
        type="text"
        class="form-control"
    />
    <div class="flex gap-2">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
        {{ form.id ? "Mettre à jour" : "Créer" }}
      </button>
      <button type="button" @click="resetForm" class="px-4 py-2 bg-gray-300 rounded">Annuler</button>
    </div>
  </form>
</template>

<script setup lang="ts">
import AppInput from "@/components/Global/AppInput.vue";
import { useForm } from "@inertiajs/vue3";
import { Category } from "@/models";
import { store } from '@/actions/App/Http/Controllers/Auth/CategoryController';

const props = defineProps<{ form?: Category }>()

const emits = defineEmits<{
  (e: 'reset')
}>()

const form = useForm<Category>(
    store().method,
    store().url,
    props.form ?? {
      name: '',
    }
)

function submit()
{
  form.submit({
    onSuccess: () => {
      emits('reset')
    }
  })
}

function resetForm()
{
  form.reset()
  emits('reset')
}
</script>

<style scoped>

</style>