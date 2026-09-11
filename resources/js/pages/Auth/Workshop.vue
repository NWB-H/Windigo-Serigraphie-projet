<template>
    <div class="container my-2">
        <div class="mx-auto max-w-6xl p-6">
            <div
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-[0_8px_30px_rgba(0,0,0,0.06)]"
            >
                <FormResumeCart :workshop="workshop" />
            </div>
            <div
                class="mt-8 overflow-hidden rounded-xl border border-gray-200 bg-white"
            >
                <TabList :items="tabs" @click="handleTabClick($event)" />
                <SessionTable
                    :sessionList="sessionList"
                    :workshop_id="workshop.id"
                    :duration="workshop.duration"
                />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {
    ResourcePaginated,
    Workshop,
    WorkshopSession,
    WorkshopSessionTab,
    WorkshopSessionTabItem,
} from '@/models';
import AppLayoutAdmin from '@/layouts/AppLayoutAdmin.vue';
import FormResumeCart from '@/components/WorkshopSession/FormResumeCart.vue';
import TabList from '@/components/WorkshopSession/TabList.vue';
import SessionTable from '@/components/WorkshopSession/SessionTable.vue';
import { computed, ref } from 'vue';

const props = defineProps<{
    workshop: Workshop;
    nextSessionsList: ResourcePaginated<Record<string, WorkshopSession>>;
    previousSessionsList: ResourcePaginated<Record<string, WorkshopSession>>;
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

const urlHashName = 'tab';
const activeTab = ref<WorkshopSessionTab>(
    new URLSearchParams(window.location.hash.substring(1)).get(urlHashName) ? new URLSearchParams(window.location.hash.substring(1)).get(urlHashName) as WorkshopSessionTab
        : 'next',
);

const sessionList = computed(() =>
    activeTab.value === 'next'
        ? props.nextSessionsList
        : props.previousSessionsList,
);

const tabs = computed<WorkshopSessionTabItem[]>(() => [
    {
        label: 'Sessions à venir',
        value: 'next',
        count: props.nextSessionsList.pagination.total,
        isActive: activeTab.value === 'next',
    },
    {
        label: 'Sessions passées',
        value: 'past',
        count: props.previousSessionsList.pagination.total,
        isActive: activeTab.value === 'past',
    },
]);

function handleTabClick(value: WorkshopSessionTab) {
    window.location.hash = '#' + urlHashName + '=' + value;
    activeTab.value = value;
}
</script>

<style scoped></style>
