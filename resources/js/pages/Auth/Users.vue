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
                    <td class="flex items-center gap-2">
                        <AppAvatar />{{ user.email }}
                    </td>
                    <td>
                        {{ useDateFormat(user.last_login_at, 'DD MMMM YYYY') }}
                    </td>
                    <td>{{ useDateFormat(user.updated_at, 'DD MMMM YYYY') }}</td>
                    <td>
                        <ToolTip :tooltip="tooltipText(user.email_verified_at)">
                            <CheckBadgeIcon
                                class="size-10"
                                color="green"
                                v-if="user.email_verified_at"
                            />
                            <XMarkIcon class="size-10" color="red" v-else />
                        </ToolTip>
                    </td>
                    <td>
                        <Link
                            v-if="isBlocked(user)"
                            :href="
                                route('admin.users.unlock', { user: user.id })
                            "
                            method="post"
                            class="link link--default"
                            >Débloquer l'utilisateur</Link
                        >
                        <Link
                            v-else
                            :href="route('admin.users.lock', { user: user.id })"
                            method="post"
                            class="link link--error"
                            >Bloquer l'utilisateur</Link
                        >
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
import AppLayoutAdmin from '@/layouts/AppLayoutAdmin.vue';
import AppPagination from '@/components/AppPagination.vue';
import { ResourcePaginated } from '@/models';
import AppAvatar from '@/components/Shop/AppAvatar.vue';
import { useDateFormat } from '@vueuse/shared';
import XMarkIcon from '@/components/Icon/XMarkIcon.vue';
import CheckBadgeIcon from '@/components/Icon/CheckBadgeIcon.vue';
import ToolTip from '@/components/ToolTip.vue';
import { Roles, User } from '@/models/User';
import { Link } from '@inertiajs/vue3';

defineOptions({
    layout: [AppLayoutAdmin, { title: 'Administration utilisateurs' }],
});
defineProps<{ users: ResourcePaginated<User> }>();

function tooltipText(emailVerified: string | null): string {
    return 'email %s'.replace('%', emailVerified ? 'vérifié' : 'non vérifié');
}

function isBlocked(user: User): boolean {
    return user.role === Roles.BLOCKED;
}
</script>

<style scoped lang="scss">
.link {
    border-radius: 0.25rem;
    padding: 0.5rem 1.5rem;
    font-weight: 600;
    box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    transition: all 0.2s ease;
    color: #ffffff;
    text-decoration: none;

    &--default {
        background-color: #16a34a;

        &:hover {
            background-color: #15803d;
        }
    }

    &--error {
        background-color: #dc2626;

        &:hover {
            background-color: #b91c1c;
        }
    }
}
</style>
