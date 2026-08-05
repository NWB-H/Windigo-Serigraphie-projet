<template>
    <div class="container my-5">
        <div class="flex gap-2">
            <h2>Gestion des utilisateurs</h2>
        </div>

        <table class="table-striped table">
            <thead>
            <tr>
                <th>Informations</th>
                <th>Dernière connexion</th>
                <th>Email validé</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                <tr
                    v-for="user in users.items"
                    :key="user.id"
                    class="align-middle"
                >
                    <td class="flex gap-2 items-center">
                        <AppAvatar />{{ user.email }}
                    </td>
                    <td>{{ useDateFormat(user.updated_at, 'DD MMMM YYYY') }}</td>
                    <td>
                        <ToolTip :tooltip="tooltipText(user.email_verified_at)">
                            <CheckBadgeIcon class="size-10" color="green" v-if="user.email_verified_at" />
                            <XMarkIcon class="size-10" color="red" v-else />
                        </ToolTip>
                    </td>
                    <td>
                        <AppButton @click="handleBlockUser(user)">Bloqué l'utilisateur</AppButton>
                    </td>
                </tr>
            </tbody>
        </table>
        <AppPagination
            v-if="users.pagination.totalPage > 1"
            :totalPage="users.pagination.totalPage"
            :currentPage="users.pagination.currentPage"
            :path="users.pagination.path"
        />
    </div>
</template>

<script setup lang="ts">
import AppLayoutAdmin from "@/layouts/AppLayoutAdmin.vue";
import AppPagination from "@/components/AppPagination.vue";
import { User } from "@/types";
import { ResourcePaginated } from "@/models";
import AppAvatar from "@/components/Shop/AppAvatar.vue";
import {useDateFormat} from "@vueuse/shared";
import XMarkIcon from "@/components/Icon/XMarkIcon.vue";
import CheckBadgeIcon from "@/components/Icon/CheckBadgeIcon.vue";
import ToolTip from "@/components/ToolTip.vue";
import AppButton from "@/components/Global/AppButton.vue";

defineOptions({
    layout: [AppLayoutAdmin, { title: 'Administration utilisateurs' }]
})
defineProps<{ users: ResourcePaginated<User> }>()

function tooltipText(emailVerified: string | null) {
    return 'email %s'.replace('%', emailVerified ? 'vérifié' : 'non vérifié')
}

function handleBlockUser(user: User) {}
</script>

<style scoped>

</style>
