<template>
    <nav
        class="mt-6 flex items-center justify-center gap-2"
        aria-label="Pagination"
    >
        <a
            v-if="currentPage > 1"
            :href="path + '?page=' + (currentPage - 1)"
            class="rounded-lg border px-3 py-2 text-gray-600 hover:bg-gray-100"
        >
            Précédent
        </a>

        <template v-for="page in totalPage" :key="page">
            <span
                v-if="page === currentPage - 3 && page !== 1"
                class="px-3 py-2 text-gray-500"
                >...</span
            >
            <a
                v-if="
                    (page <= currentPage + 2 && page >= currentPage - 2) ||
                    (page === totalPage && currentPage !== totalPage) ||
                    (page === 1 && currentPage !== 1)
                "
                :href="path + '?page=' + page"
                class="rounded-lg border px-3 py-2"
                :class="[
                    page === currentPage
                        ? 'bg-blue-600 text-white'
                        : 'text-gray-700 hover:bg-gray-100',
                ]"
            >
                {{ page }}
            </a>
            <span
                v-if="page === currentPage + 3 && page !== totalPage"
                class="px-3 py-2 text-gray-500"
                >...</span
            >
        </template>
        <a
            v-if="currentPage < totalPage"
            :href="path + '?page=' + (currentPage + 1)"
            class="rounded-lg border px-3 py-2 text-gray-600 hover:bg-gray-100"
        >
            Suivant
        </a>
    </nav>
</template>

<script setup lang="ts">
defineProps<{
    totalPage: number;
    currentPage: number;
    path: string;
}>();
</script>

<style scoped></style>
