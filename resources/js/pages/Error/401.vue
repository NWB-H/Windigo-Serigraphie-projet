<template>
    <section
        class="mx-auto flex min-h-[80vh] w-full items-center justify-center bg-[#f7f3f0] px-6 py-16 text-gray-800"
    >
        <div class="mx-auto max-w-2xl text-center">
            <h2
                class="mt-6 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl"
            >
                Authentification requise
            </h2>

            <p class="mt-4 text-base leading-7 text-gray-600 sm:text-lg">
                Vous devez être connecté pour accéder à cette page.
                Connectez-vous à votre compte pour continuer.
            </p>

            <div
                class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row"
            >
                <Link
                    :href="route('login')"
                    class="rounded-full bg-[#a78770] px-6 py-3 text-sm font-semibold text-white !no-underline shadow-lg shadow-[#7a6256]/20 transition hover:bg-[#8f6e58]"
                >
                    Se connecter
                </Link>

                <Link
                    :href="route('home')"
                    class="rounded-full border border-[#bfa79a] bg-white px-6 py-3 text-sm font-semibold text-[#7a6256] !no-underline transition hover:bg-[#eee5df]"
                >
                    Accueil
                </Link>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineOptions({
    layout: [AppLayout, { title: 'Accès refusé' }],
});
</script>

<style scoped></style>
