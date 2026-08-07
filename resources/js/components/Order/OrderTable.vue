<template>
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 text-xs text-gray-600 uppercase">
            <tr>
                <th class="px-4 py-3">Commande</th>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3">Statut</th>
                <th class="px-4 py-3 text-right">Total</th>
                <th class="px-4 py-3 text-right">Action</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
            <tr
                v-for="order in orders"
                :key="order.id"
                class="hover:bg-gray-50"
            >
                <td class="px-4 py-4 font-medium text-gray-900">{{ order.id }}</td>
                <td class="px-4 py-4 text-gray-600">{{ useDateFormat(order.created_at, 'DD MMMM YYYY') }}</td>
                <td class="px-4 py-4 text-gray-600">{{ order.status }}</td>
                <td class="px-4 py-4 text-gray-600">{{ order.total }}</td>
                <td class="px-4 py-4 text-right">
                    <a
                        href="#"
                        class="font-medium text-gray-700 hover:text-black"
                    >
                        Voir
                    </a>
                </td>
        </tr>
        </tbody>
    </table>
</template>

<script setup lang="ts">
import {Order} from "@/models";
import { useDateFormat } from "@vueuse/shared";

defineProps<{ orders: Order[] }>()
</script>

<style scoped>

</style>
