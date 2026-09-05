<template>
    <Head title="Profile" />
    <div class="min-h-screen w-[50%] px-4 py-10">
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
                @edit="(address) => updateModal(address)"
                @delete="(address) => handleDeleteAddress(address)"
            />
            <!-- Bloc 3 : Tableau commandes -->
            <section class="rounded-2xl bg-white p-6 shadow-sm">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">
                    Mes commandes
                </h2>

                <div class="overflow-x-auto">
                    <OrderTable
                        v-if="user.orders.length > 0"
                        :orders="user.orders"
                    />
                    <AppEmptyList v-else>
                        <template #content>
                            Pas de commande actuellement
                        </template>
                    </AppEmptyList>
                </div>
            </section>
        </div>
    </div>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { inject } from 'vue';
import { modalKey } from '@/keys';
import { Address } from '@/models/Address';
import AddressRepository from '@/services/AddressRepository';
import AddressList from '@/components/Address/AddressList.vue';
import { Roles, User } from '@/models/User';
import AppLayoutAdmin from '@/layouts/AppLayoutAdmin.vue';
import OrderTable from '@/components/Order/OrderTable.vue';
import AppEmptyList from '@/components/Global/AppEmptyList.vue';

defineOptions({
    layout: (h, page) => {
        return h(
            page.props.user.role === Roles.ADMIN ? AppLayoutAdmin : AppLayout,
            () => page,
        );
    },
});

defineProps<{ user: User }>();

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
