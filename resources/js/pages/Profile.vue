<template>
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

            <section class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900">
                        Mes adresses
                    </h2>
                    <span class="text-sm text-gray-500"
                        >Maximum 5 adresses</span
                    >
                </div>

                <div
                    class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5"
                >
                    <AppButton
                        type="button"
                        ignoreStyle
                        class="flex min-h-48 items-center justify-center rounded-xl border-2 border-dashed border-gray-300 transition hover:border-gray-900 hover:bg-gray-50"
                    >
                        <span class="text-5xl text-gray-400">+</span>
                    </AppButton>

                    <!-- Exemple card adresse -->
                    <div
                        v-for="address in user.addresses"
                        :key="address.id"
                        class="flex min-h-48 flex-col justify-between rounded-xl border border-gray-200 p-4"
                    >
                        <div>
                            <h3 class="font-semibold text-gray-900">
                                {{ address.name }}
                            </h3>

                            <p class="mt-3 text-sm text-gray-600">
                                {{ address.address_line1 }}
                            </p>

                            <p class="text-sm text-gray-600">
                                {{ address.city.postal_code }}
                                {{ address.city.name }}
                            </p>

                            <p class="text-sm text-gray-600">address.country</p>
                        </div>

                        <div class="flex gap-3 pt-4 text-sm">
                            <button
                                class="text-gray-700 hover:text-black"
                                @click="modal.updateModal('edit-address')"
                            >
                                Modifier
                            </button>
                            <button class="text-red-500 hover:text-red-700">
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </section>

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
                            <!--                            @empty-->
                            <!--                            <tr>-->
                            <!--                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">-->
                            <!--                                    Aucune commande passée pour le moment.-->
                            <!--                                </td>-->
                            <!--                            </tr>-->
                            <!--                            @endforelse-->
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { usePage } from '@inertiajs/vue3';
import { inject, ref } from 'vue';
import AuthenticatedUserPage from '@/types/inertia';
import { User } from '@/types';
import AppButton from '@/components/Global/AppButton.vue';
import { modalKey } from '@/keys';
import { add } from 'es-toolkit/compat';

defineOptions({
    layout: [AppLayout, { title: 'Profile' }],
    title: 'Mon compte',
});

const page = usePage<AuthenticatedUserPage>();

const user = ref<User>(page.props.auth.user);

console.log(user.value);

const modal = inject(modalKey);

if (!modal) {
    throw new Error('modalKey not provided');
}
</script>

<style scoped></style>
