<template>
    <form @submit.prevent="submit">
        <div class="flex flex-column">
            <AppInput
                id="name"
                v-model="form.name"
                type="text"
                placeholder="Intitulé (Maison, Travail...)"
                inputContainerClass="bg-white"
            />

                <AppInput
                    id="address_line1"
                    name="address_line1"
                    v-model="form.address_line1"
                    type="text"
                    placeholder="Adresse"
                    inputContainerClass="bg-white"
                />
                <AppInput
                    id="address_line2"
                    v-model="form.address_line2"
                    type="text"
                    placeholder="Complement"
                    inputContainerClass="bg-white"
                />

            <!-- Postal Code -->
            <AppInput
                id="postal_code"
                v-model="form.postal_code"
                type="text"
                placeholder="Code postal"
                inputContainerClass="bg-white"
            />

            <AppInput
                id="city"
                v-model="form.city.nom"
                type="text"
                placeholder="Ville"
                inputContainerClass="bg-white"
            />

            <AppInput
                id="country"
                v-model="form.country"
                type="text"
                placeholder="France"
                inputContainerClass="bg-white"
            />
        </div>

        <div class="flex justify-end">
            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-6 py-2 text-white font-medium hover:bg-blue-700 transition-colors"
            >
                Save Address
            </button>
        </div>
    </form>
</template>

<script setup lang="ts">
import { reactive } from 'vue'
import AppInput from "@/components/Global/AppInput.vue";
import { Address } from '@/models/Address';

const { address } = defineProps<{ address?: Address }>()

const form = reactive({
    name: address?.name ?? '',
    address_line1: address?.address_line1 ?? '',
    address_line2: address?.address_line2 ?? '',
    postal_code: address?.postal_code ?? '',
    city: address?.city ?? '',
    country: address?.country ?? ''
})

const submit = () => {
    console.log(form)
}
</script>
