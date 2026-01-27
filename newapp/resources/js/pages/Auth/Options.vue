<template>
  <AppLayoutAdmin>
    <div class="container my-5">
      <p class="flex gap-2">
        <h2>Gestion des Options</h2>
        <button @click.prevent="newOption" class="btn btn-success">Nouvelle option</button>
      </p>

      <div v-if="showForm" class="card p-3 mb-4">
        <OptionForm
          :form="currentOption"
          :key="currentOption ? currentOption.id : 'new-option'"
          @reset="showForm = false"
        />
      </div>

      <table class="table table-striped">
        <thead>
        <tr>
          <th>ID</th>
          <th>Nom</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="option in options" :key="option.id">
          <td>{{ option.id }}</td>
          <td>{{ option.name }}</td>
          <td class="flex gap-2">
            <button @click.prevent="edit(option)" class="px-2 py-1 bg-yellow-400 rounded">✏️</button>
            <button @click.prevent="deleteOptions(option)" class="px-2 py-1 bg-red-500 text-white rounded">🗑️</button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </AppLayoutAdmin>
</template>

<script setup lang="ts">
import AppLayoutAdmin from "@/layouts/AppLayoutAdmin.vue";
import {Option} from "@/models";
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import OptionForm from "@/components/Form/OptionForm.vue";
import OptionRepository from "@/services/OptionRepository";

const props = defineProps<{ options: Option[] }>()

const showForm = ref(false)
const currentOption = ref<Option | undefined>()

function newOption()
{
  currentOption.value = undefined
  showForm.value = true
}

function edit(option: Option)
{
  currentOption.value = option
  showForm.value = true
}

function deleteOptions(option: Option)
{
  const index = props.options.findIndex((_: Option) => _.id === option.id)

  if (index !== -1) {
    OptionRepository.deleteOption(option).then(() => {
      props.options.splice(index, 1)
      router.flash('toast', { message: 'Option supprimée avec succès', type: 'success'})
    })
  }
}
</script>

<style scoped>

</style>