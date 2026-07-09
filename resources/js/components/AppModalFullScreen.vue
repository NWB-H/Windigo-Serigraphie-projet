<template>
    <div
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/70"
    >
        <div class="w-full max-w-lg rounded-xl bg-white p-8 shadow-2xl">
            <slot>
                <h2 class="mb-4 text-2xl font-bold">Erreur</h2>

                <p class="mb-6 text-gray-600">
                    Votre modal n'a pas pu être chargé correctement
                </p>
            </slot>
        </div>
    </div>
</template>

<script setup lang="ts">
</script>

<style scoped></style>
