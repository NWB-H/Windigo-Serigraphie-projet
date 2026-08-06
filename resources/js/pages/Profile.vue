<template>
    <Head title="Profile" />
    <div class="min-h-screen px-4 py-10">
        <div class="mx-auto max-w-7xl space-y-8">
            <section class="rounded-2xl bg-white p-6 shadow-sm">
                <div
                    class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
                >
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">
                            Bienvenue, {{ user.name }}
                        </h1>
                        <p class="mt-2 text-gray-600">
                            Heureux de vous revoir sur votre espace personnel.
                        </p>
                    </div>
                </div>
            </section>

            <AddressList
                :addresses="user.addresses"
                @add="updateModal()"
                @edit="address => updateModal(address)"
                @delete="address => handleDeleteAddress(address)"
            />
            <!-- Bloc 3 : Tableau commandes -->
            <section class="rounded-2xl bg-white p-6 shadow-sm">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">
                    Mes commandes
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead
                            class="bg-gray-50 text-xs text-gray-600 uppercase"
                        >
                            <tr>
                                <th class="px-4 py-3">Commande</th>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Paiement</th>
                                <th class="px-4 py-3">Statut</th>
                                <th class="px-4 py-3 text-right">Total</th>
                                <th class="px-4 py-3 text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 font-medium text-gray-900">
                                    #ID
                                </td>

                                <td class="px-4 py-4 text-gray-600">
                                    CreatedAt
                                </td>

                                <td class="px-4 py-4 text-gray-600">A voir</td>

                                <td class="px-4 py-4">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-medium"
                                    >
                                        order.status
                                    </span>
                                </td>

                                <td
                                    class="px-4 py-4 text-right font-semibold text-gray-900"
                                >
                                    order.total €
                                </td>

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
                </div>
            </section>
        </div>
    </div>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import {Head, router } from '@inertiajs/vue3';
import { inject } from 'vue';
import { modalKey } from '@/keys';
import { Address } from '@/models/Address';
import AddressRepository from '@/services/AddressRepository';
import AddressList from "@/components/Address/AddressList.vue";
import {Roles, User} from "@/models/User";
import AppLayoutAdmin from "@/layouts/AppLayoutAdmin.vue";

defineOptions({
    layout: (h, page) => {
        return h(
            page.props.user.role === Roles.ADMIN ? AppLayoutAdmin : AppLayout,
            () => page
        )
    },
});

const props = defineProps<{ user: User }>();

const modal = inject(modalKey);

function updateModal(address?: Address) {
    if (!modal) {
        throw new Error('modalKey not provided');
    }
    modal.updateModal('address', { address: address });
}

async function handleDeleteAddress(address: Address) {
    try {
        await AddressRepository.deleteAddress(address);

        router.reload({
            only: ['user'],
            onSuccess: () => {
                router.flash('notification', {
                    message: 'Adresse supprimé avec succès',
                    type: 'success',
                });
            },
        });
    } catch (e) {
        console.log(e);
    }
}
</script>

<style scoped></style>
