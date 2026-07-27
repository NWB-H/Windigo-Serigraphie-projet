<template>
    <div class="flex items-center justify-center bg-slate-50 px-4">
        <div
            class="w-full max-w-lg min-w-[512px] rounded-3xl border border-slate-200 bg-white p-8 shadow-xl"
        >
            <VerifySuccess v-if="isVerifyAccount" />
            <VerifyFailure v-else />
        </div>
    </div>
</template>

<script setup lang="ts">
import VerifyFailure from '@/components/VerifyFailure.vue';
import VerifySuccess from '@/components/VerifySuccess.vue';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({
    layout: AppLayout,
});
defineProps<{ isVerifyAccount: boolean }>();
</script>

<style scoped></style>
