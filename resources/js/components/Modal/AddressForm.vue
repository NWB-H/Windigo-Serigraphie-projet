<template>
    <form @submit.prevent="submit">
        <div class="flex flex-column">
            <AppInput
                id="name"
                v-model="form.name"
                :error="form.errors.name"
                type="text"
                placeholder="Intitulé (Maison, Travail...)"
                inputContainerClass="bg-white"
            />

                <AppInput
                    id="address_line1"
                    name="address_line1"
                    v-model="form.address_line1"
                    :error="form.errors.address_line1"
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
                :error="form.errors.postal_code"
                type="text"
                placeholder="Code postal"
                inputContainerClass="bg-white"
            />

            <AppInput
                id="city"
                v-model="form.city"
                :error="form.errors.city"
                type="text"
                placeholder="Ville"
                inputContainerClass="bg-white"
            />

            <AppInput
                id="country"
                v-model="form.country"
                :error="form.errors.country"
                type="text"
                placeholder="Pays"
                inputContainerClass="bg-white"
            />
        </div>

        <div class="flex gap-2 justify-end">
            <AppButton
            >
                {{ address.id ? 'Modifier' : 'Créer' }}
            </AppButton>
            <AppButton @click="modal.toggleModal()">
                Annuler
            </AppButton>
        </div>
    </form>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import AppInput from "@/components/Global/AppInput.vue";
import { Address, AddressForm } from '@/models/Address';
import AppButton from "@/components/Global/AppButton.vue";
import { modalKey } from "@/keys";
import { injectStrict } from "@/composable/injectStrict";
import {router, useForm } from "@inertiajs/vue3";
import { store } from '@/actions/App/Http/Controllers/Auth/AddressController'

const props = defineProps<{ address?: Address }>()

const modal = injectStrict(modalKey)

const address = ref(props.address ?? {
    name: '',
    address_line1: '',
    address_line2: undefined,
    postal_code: '',
    city: '',
    country: ''
})

const form = useForm<AddressForm>(
    store().method,
    store().url,
    {
        id: address.value.id,
        address_line1: address.value.address_line1,
        address_line2: address.value.address_line2,
        name: address.value.name,
        postal_code: address.value.postal_code,
        country: address.value.country,
        city: address.value.city
    }
)

const submit = () => {
    form.submit(
    {
            onSuccess: () => {
                router.reload({
                    onSuccess: () => {
                        router.flash('notification', {
                            message: form.id ? 'Adresse modifée' : 'Adresse crée',
                            type: 'success',
                        });
                    },
                });

                modal.toggleModal()
            }
        },
    )
}
</script>
