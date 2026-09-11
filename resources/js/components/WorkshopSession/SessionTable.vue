<template>
    <div class="overflow-x-auto p-4" v-if="sessionList.pagination.total > 0">
        <table class="w-full text-left">
            <thead class="border-b border-gray-200 bg-gray-50/50">
                <tr>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-900">
                        Date
                    </th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-900">
                        Capacité
                    </th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-900">
                        Places restantes
                    </th>
                    <th
                        class="px-6 py-4 text-right text-sm font-semibold text-gray-900"
                    >
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                <template
                    v-for="(sessions, date) in sessionList.items"
                    :key="date"
                >
                    <tr class="bg-gray-100">
                        <td
                            colspan="4"
                            class="px-4 py-2 font-semibold text-gray-700"
                        >
                            {{ useDateFormat(date, 'DD MMMM YYYY') }}
                        </td>
                    </tr>
                    <tr
                        v-for="session in sessions"
                        :key="session.id"
                        class="bg-white hover:bg-gray-50"
                    >
                        <td>
                            {{ useDateFormat(session.date, 'HH:mm') }} -
                            {{
                                useDateFormat(
                                    finishSession(session.date),
                                    'HH:mm',
                                )
                            }}
                        </td>
                        <td>{{ session.capacity }}</td>
                        <td>todo</td>
                        <td class="flex gap-2 p-1">
                            <AppButton
                                ignoreStyle
                                class="rounded bg-yellow-400 px-2 py-1"
                                type="default"
                                @click="editSession(session)"
                            >
                                ✏️
                            </AppButton>
                            <Link
                                class="rounded bg-red-500 px-2 py-1 text-white"
                                method="delete"
                                :href="
                                    route('admin.workshops.sessions.delete', {
                                        workshop: workshop_id,
                                        session: session.id,
                                    })
                                "
                            >
                                🗑️
                            </Link>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
        <AppPagination
            v-if="sessionList.pagination.totalPage > 1"
            :totalPage="sessionList.pagination.totalPage"
            :currentPage="sessionList.pagination.currentPage"
            :path="sessionList.pagination.path"
            :pageName="sessionList.pagination.pageName"
        />
    </div>

    <div
        v-else
        class="flex flex-col items-center justify-center px-6 py-16 text-center"
    >
        <div
            class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-[#b18e76]/10 text-[#b18e76]"
        >
            <CalendarIcon class="h-6 w-6" />
        </div>

        <h3 class="text-base font-semibold text-gray-900">
            Aucune session à venir
        </h3>

        <p class="mt-1 max-w-sm text-sm text-gray-500">
            Les prochaines sessions de cet atelier apparaîtront ici. Ajoutez une
            session avec le formulaire ci-dessus.
        </p>
    </div>
</template>

<script setup lang="ts">
import { ResourcePaginated, WorkshopSession } from '@/models';
import { useDateFormat } from '@vueuse/shared';
import { Link } from '@inertiajs/vue3';
import AppButton from '@/components/Global/AppButton.vue';
import CalendarIcon from '@/components/Icon/CalendarIcon.vue';
import AppPagination from '@/components/AppPagination.vue';

const props = defineProps<{
    sessionList: ResourcePaginated<Record<string, WorkshopSession>>;
    workshop_id: number;
    duration: number;
}>();

function finishSession(date: string) {
    return new Date(new Date(date).getTime() + props.duration * 60_000);
}
</script>

<style scoped></style>
