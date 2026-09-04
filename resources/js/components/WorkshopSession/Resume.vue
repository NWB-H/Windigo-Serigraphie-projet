<template>
    <div
        class="border-b border-slate-100 bg-gradient-to-r from-[#faf7f5] to-white px-6 py-6 md:px-8"
    >
        <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
            <div
                class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-[#ede5df]"
            >
                <CalendarIcon class="h-8 w-8" color="grey" />
            </div>

            <div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                    {{ workshop.name }}
                </h1>

                <div
                    class="mt-3 flex flex-wrap items-center gap-x-6 gap-y-3 text-sm text-slate-700"
                >
                    <div class="flex items-center gap-2">
                        <ClockIcon class="h-4 w-4" />
                        <span>
                            Durée :
                            <strong class="font-semibold text-slate-900"
                                >{{ workshop.duration }} min</strong
                            >
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <TagIcon class="h-4 w-4" />
                        <span>
                            Prix :
                            <strong class="font-semibold text-slate-900"
                                >{{ workshop.price }} €</strong
                            >
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <UsersIcon class="h-4 w-4" />
                        <span>
                            Âge :
                            <strong class="font-semibold text-slate-900">
                                {{ workshop.age }} ans et plus
                            </strong>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Workshop } from '@/models';
import ClockIcon from '@/components/Icon/ClockIcon.vue';
import UsersIcon from '@/components/Icon/UsersIcon.vue';
import TagIcon from '@/components/Icon/TagIcon.vue';
import CalendarIcon from "@/components/Icon/CalendarIcon.vue";

defineProps<{ workshop: Workshop }>();
</script>

<style scoped></style>
