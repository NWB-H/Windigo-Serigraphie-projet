<template>
    <div
        class="flex flex-col gap-4 rounded-[28px] border border-gray-100 bg-white px-12 py-14"
    >
        <h2 class="mb-10 text-3xl font-semibold text-gray-900">
            {{ useDateFormat(selectedDate, 'dddd DD MMMM YYYY') }}
        </h2>
        <div class="flex flex-col gap-2 space-y-4">
            <button
                v-for="(session, key) in sessions"
                :key="session.id"
                @click.prevent="selectedSession = key"
                type="button"
                class="flex w-full items-center justify-between rounded border px-8 py-7"
                :class="[
                    selectedSession === key
                        ? 'border-[#E8D6CA] bg-[#FCF8F5]'
                        : 'border-gray-200 bg-white',
                ]"
            >
                <span class="flex items-center gap-6">
                    <input
                        type="radio"
                        name="session"
                        v-model="selectedSession"
                        :value="key"
                        class="h-10 w-10 cursor-pointer appearance-none rounded-full border-[3px] border-gray-200 checked:border-10 checked:border-[#C79A7B] checked:bg-white"
                    />
                    <span class="text-2xl font-medium text-gray-600">
                        {{ useDateFormat(session.date, 'HH:mm') }} -
                        {{
                            useDateFormat(finishSession(session.date), 'HH:mm')
                        }}
                    </span>
                </span>

                <span
                    v-if="session.remaining_places > 0"
                    class="rounded-xl bg-green-50 px-8 py-3 text-xl font-medium text-green-800"
                >
                    {{ session.remaining_places }} places restantes
                </span>
                <span
                    v-else
                    class="rounded-xl bg-red-50 px-12 py-3 text-xl font-medium text-red-700"
                >
                    Complet
                </span>
            </button>
            <AppEmptyList v-if="sessions.length === 0">
                <template #content>Aucune sessions</template>
                <template #subcontent>Actuellement aucune session de prévu à cette date</template>
            </AppEmptyList>
        </div>
        <button
            type="button"
            class="w-full rounded bg-[#B98F76] py-6 text-3xl font-medium text-white"
            :disabled="sessions[selectedSession]?.remaining_places === 0"
        >
            Réserver cette session
        </button>
    </div>
</template>

<script setup lang="ts">
import { WorkshopSession } from '@/models';
import { useDateFormat } from '@vueuse/shared';
import { ref } from 'vue';
import AppEmptyList from '@/components/Global/AppEmptyList.vue';

const props = defineProps<{
    selectedDate: Date;
    duration: number;
    workshopName: string;
    sessions: WorkshopSession[];
}>();

const selectedSession = ref(0);
function finishSession(date: string) {
    return new Date(new Date(date).getTime() + props.duration * 60_000);
}
</script>

<style scoped></style>
