<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>
<template>
    <div>
        <slot name="header"></slot>

        <div class="mt-6 text-center">
            <slot name="content"></slot>
        </div>

        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
            <Link
                :href="route('login')"
                class="no-underline! rounded-xl border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
            >
                Retour à la connexion
            </Link>
        </div>
    </div>
</template>

<style scoped></style>
