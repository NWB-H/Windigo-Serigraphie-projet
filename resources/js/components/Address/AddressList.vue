<template>
    <section class="rounded-2xl bg-white p-6 shadow-sm">
        <slot name="header" v-if="includeHeader">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900">
                    Mes adresses
                </h2>
                <span class="text-sm text-gray-500"
                >Maximum 5 adresses</span
                >
            </div>
        </slot>

        <div
            class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5"
        >
            <AppButton
                v-if="addresses.length < 5 && actions.addAddress"
                @click="emits('add')"
                ignoreStyle
                class="flex min-h-48 items-center justify-center rounded-xl border-2 border-dashed border-gray-300 transition hover:border-gray-900 hover:bg-gray-50"
            >
                <span class="text-5xl text-gray-400">+</span>
            </AppButton>

            <template v-for="address in addresses">
                <AddressCard
                    :address="address"
                    :actions="actions.card"
                    @edit="emits('edit', address)"
                    @delete="emits('delete', address)"
                    @click.prevent="actions.card.click && handleClick(address)"
                    :class="address.id === selectedAddress?.id ? 'border-red-500!' : ''"
                />
            </template>
        </div>
    </section>
</template>

<script setup lang="ts">
import AppButton from "@/components/Global/AppButton.vue";
import {Address} from "@/models/Address";
import AddressCard, { Actions as AddressCardActions } from "@/components/Address/AddressCard.vue";
import {ref} from "vue";

export interface Actions {
    addAddress?: boolean,
    card?: AddressCardActions,
    hover?: boolean,
}

const { includeHeader = true, actions = { addAddress: true } } = defineProps<{
    addresses: Address[],
    includeHeader?: boolean,
    actions?: Actions
}>()

const emits = defineEmits<{
    (e: 'add'): void,
    (e: 'click'): void,
    (e: 'edit', address: Address),
    (e: 'delete', address: Address)
}>()

const selectedAddress = ref<Address | null>(null)

function handleClick(address: Address) {
    selectedAddress.value = address
    emits('edit', address)
}
</script>

<style scoped>

</style>
