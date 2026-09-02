<template>
    <div class="mt-8 rounded-2xl border border-gray-200 bg-white p-6">
        <div class="flex items-start justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    Adresse de livraison
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Votre commande sera expédiée à cette adresse.
                </p>
            </div>

            <AppButton
                @click="$emit('edit')"
                ignoreStyle
                class="text-sm font-medium text-[#3E7C59] no-underline hover:underline"
            >
                Modifier
            </AppButton>
        </div>

        <div class="rounded-xl bg-gray-50 p-4">
            <p class="font-semibold text-gray-900">
                {{ address.name }}
            </p>

            <p class="mt-1 text-gray-700">
                {{ address.address_line1 }}
            </p>

            <div class="mt-1 text-gray-700" v-if="address.address_line2">
                {{ address.address_line2 }}
            </div>

            <p class="text-gray-700">
                {{ address.postal_code }} {{ address.city }}
            </p>

            <p class="text-gray-700">
                {{ address.country }}
            </p>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Address } from '@/models/Address';
import AppButton from '@/components/Global/AppButton.vue';

defineProps<{ address: Address }>();

defineEmits<{
    (e: 'edit');
}>();
</script>

<style scoped></style>
