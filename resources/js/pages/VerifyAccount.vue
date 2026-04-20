<template>
    <AppLayout>
        <div class="flex items-center justify-center bg-slate-50 px-4">
            <div class="w-full max-w-lg rounded-3xl border border-slate-200 bg-white p-8 shadow-xl min-w-[512px]">
                <VerifySuccess v-if="isVerifyAccount" />
                <VerifyFailure v-else />
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import VerifySuccess from "@/components/VerifySuccess.vue";
import VerifyFailure from "@/components/VerifyFailure.vue";

defineProps<{ isVerifyAccount: boolean }>()
</script>

<style scoped>

</style>
