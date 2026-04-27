<template>
    <VerifyAccount>
        <template #header>
            <ErrorIcon class="mx-auto size-18 text-red-500" />
        </template>
        <template #content>
            <h2 class="text-3xl font-bold tracking-tight text-slate-900">
                Confirmation échoué
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                Le lien que vous avez suivi ne semble plus valide.
            </p>
        </template>
    </VerifyAccount>
</template>

<script setup lang="ts">
import ErrorIcon from '@/components/Icon/ErrorIcon.vue';
import VerifyAccount from '@/components/VerifyAccount.vue';
</script>

<style scoped></style>
