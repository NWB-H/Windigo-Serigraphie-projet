<template>
    <div
        class="flex min-h-48 flex-col justify-between rounded-xl border p-4"
        :class="[
            $attrs.class ? $attrs.class : '',
            actions.hover ? 'hover:cursor-pointer' : '',
        ]"
    >
        <div>
            <h5 class="font-semibold text-gray-900">
                {{ address.name }}
            </h5>

            <p class="mt-3 text-sm text-gray-600">
                {{ address.address_line1 }}
            </p>

            <p class="text-sm text-gray-600">
                {{ address.postal_code }}
                {{ address.city }}
            </p>

            <p class="text-sm text-gray-600">
                {{ address.country }}
            </p>
        </div>

        <div class="flex gap-3 pt-4 text-sm" v-if="actions.footer">
            <AppButton
                ignoreStyle
                class="text-gray-700 hover:text-black"
                @click.prevent="emits('edit', address)"
            >
                Modifier
            </AppButton>
            <AppButton
                ignoreStyle
                class="text-red-500 hover:text-red-700"
                @click.prevent="emits('delete', address)"
            >
                Supprimer
            </AppButton>
        </div>
    </div>
</template>

<script setup lang="ts">
import AppButton from '@/components/Global/AppButton.vue';
import { Address } from '@/models/Address';

export interface Actions {
    click?: boolean;
    hover?: boolean;
    footer?: boolean;
}

const { actions = { click: false, hover: false, footer: true } } = defineProps<{
    address: Address;
    actions?: Actions;
}>();

const emits = defineEmits<{
    (e: 'edit', address: Address);
    (e: 'delete', address: Address);
}>();
</script>

<style scoped></style>
