<template>
    <div
        class="flex items-center justify-between rounded-2xl border bg-white p-6 shadow-sm"
    >
        <div class="flex items-center gap-4">
            <div class="rounded-xl bg-slate-100 p-3">
                <slot name="icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 text-slate-500"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M3 7h18M3 12h18M3 17h12"
                        />
                    </svg>
                </slot>
            </div>

            <div>
                <h3 class="font-semibold text-slate-900">
                    <slot name="content">Rien à afficher</slot>
                </h3>
                <p class="text-sm text-slate-500">
                    <slot name="subcontent">
                        Cette section est vide pour le moment.
                    </slot>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts"></script>

<style scoped></style>
