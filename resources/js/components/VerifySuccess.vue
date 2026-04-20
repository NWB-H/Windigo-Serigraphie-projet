<template>
    <VerifyAccount>
        <template #header>
            <CheckBadgeIcon class="mx-auto size-18 text-green-500" />
        </template>
        <template #content>
            <h2 class="text-3xl font-bold tracking-tight text-slate-900">
                Confirmation réussie
            </h2>

            <p class="mt-3 text-base text-slate-600">
                Merci, votre adresse email a bien été vérifiée.
            </p>

            <p class="mt-2 text-sm text-slate-500">
                Votre compte est maintenant actif. Vous pouvez vous connecter et commencer à utiliser l’application.
            </p>
        </template>
    </VerifyAccount>
</template>

<script setup lang="ts">
import CheckBadgeIcon from "@/components/Icon/CheckBadgeIcon.vue";
import VerifyAccount from "@/components/VerifyAccount.vue";
</script>

<style scoped>

</style>
