<template>
    <div class="container my-2">
        <div class="mx-auto max-w-6xl p-6">
            <div
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-[0_8px_30px_rgba(0,0,0,0.06)]"
            >
                <FormResumeCart :workshop="workshop" />
            </div>
        </div>
        <table class="table-striped table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Capacité</th>
                    <th>Places restantes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <template
                    v-for="(sessions, date) in sessionsList.items"
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
                        <td class="flex gap-2">
                            <AppButton
                                ignoreStyle
                                class="rounded bg-yellow-400 px-2 py-1"
                                type="default"
                            >
                                ✏️
                            </AppButton>
                            <Link
                                class="rounded bg-red-500 px-2 py-1 text-white"
                                method="delete"
                                :href="
                                    route('admin.workshops.sessions.delete', {
                                        workshop: workshop.id,
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
            v-if="sessionsList.pagination.totalPage > 1"
            :totalPage="sessionsList.pagination.totalPage"
            :currentPage="sessionsList.pagination.currentPage"
            :path="sessionsList.pagination.path"
        />
    </div>
</template>

<script setup lang="ts">
import { ResourcePaginated, Workshop, WorkshopSession } from '@/models';
import { useDateFormat } from '@vueuse/shared';
import AppLayoutAdmin from '@/layouts/AppLayoutAdmin.vue';
import AppButton from '@/components/Global/AppButton.vue';
import { Link } from '@inertiajs/vue3';
import AppPagination from '@/components/AppPagination.vue';
import FormResumeCart from '@/components/WorkshopSession/FormResumeCart.vue';

const props = defineProps<{
    workshop: Workshop;
    sessionsList: ResourcePaginated<Record<string, WorkshopSession>>;
}>();

defineOptions({
    layout: (props: {
        workshop: Workshop;
        sessionsList: Record<string, WorkshopSession>;
    }) => [
        AppLayoutAdmin,
        {
            title: 'Administration atelier '.concat(props.workshop.name),
        },
    ],
});

function finishSession(date: string) {
    return new Date(
        new Date(date).getTime() + props.workshop.duration * 60_000,
    );
}
</script>

<style scoped></style>
