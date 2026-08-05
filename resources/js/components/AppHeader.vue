<template>
    <header>
        <div class="header-container">
            <Link :href="route('home')" class="logo">
                <img src="/images/logo.png" alt="Logo Windigo" />
            </Link>

            <nav class="nav-links">
                <Link :href="route('shop')">BOUTIQUE</Link>
                <Link :href="route('workshops')" v-if="page.props.enabled">ATELIERS</Link>
                <Link :href="route('portfolio')" v-if="page.props.enabled">PORTFOLIO</Link>
                <Link :href="route('about')">A PROPOS</Link>
            </nav>

            <div class="user-actions">
                <div v-if="user" class="logged-in">
                    <Link
                        v-if="user.role === 'ROLE_ADMIN'"
                        :href="route('admin.product.index')"
                        class="text-black! no-underline! hover:text-gray-600!"
                        ><ProfileIcon
                    /></Link>
                    <ToolTip v-else tooltip="Profile" direction="down">
                        <Link
                            class="text-black! no-underline! hover:text-gray-600!"
                            :href="route('profile')"
                        >
                            <ProfileIcon />
                        </Link>
                    </ToolTip>

                    <ToolTip tooltip="Déconnexion" direction="down">
                        <Link
                            type="button"
                            as="button"
                            class="text-black! no-underline! hover:text-red-600!"
                            :href="route('logout')"
                        >
                            <LogoutIcon />
                        </Link>
                    </ToolTip>
                </div>
                <Link :href="route('cart')" v-if="totalCartItem > 0">
                    <p class="cart bg-secondary">
                        Panier
                        <span class="badge-cart">{{ totalCartItem }}</span>
                    </p>
                </Link>
                <ToolTip tooltip="Connexion" direction="down">
                    <Link
                        v-if="!user"
                        :href="route('login')"
                        class="text-black! no-underline!"
                    >
                        <ProfileIcon />
                    </Link>
                </ToolTip>
            </div>
        </div>
    </header>
</template>

<script setup lang="ts">
import { useCartStore } from '@/stores/Cart';
import { User } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { storeToRefs } from 'pinia';
import { computed } from 'vue';
import LogoutIcon from '@/components/Icon/LogoutIcon.vue';
import ProfileIcon from '@/components/Icon/ProfileIcon.vue';
import ToolTip from '@/components/ToolTip.vue';

const page = usePage();

const user = computed<User | null>(() => page.props.auth?.user);

const { totalCartItem } = storeToRefs(useCartStore());
</script>

<style scoped>
header {
    position: sticky;
    top: 0;
    left: 0;
    width: 100%;
    background: #a88871;
    z-index: 1000;
    display: flex;
    justify-content: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    font-family: 'Oswald', sans-serif;
    font-weight: 200; /* Extralight */
}

.header-container {
    max-width: 1200px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 2rem;
}

.logo img {
    height: 50px;
    object-fit: contain;
}

nav a {
    margin: 0 12px;
    text-decoration: none;
    color: black;
    font-weight: 200; /* Extralight */
    position: relative;
    transition: color 0.3s ease;
}

nav a::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0;
    width: 0%;
    height: 2px;
    background-color: #333;
    transition: width 0.3s ease-in-out;
}

nav a:hover::after {
    width: 100%;
}

a {
    text-decoration: none;
}

.cart {
    position: relative;
    padding: 4px 8px;
    margin: 0;
    color: white;
    text-decoration: none;
    border-radius: 4px;
}

.badge-cart {
    position: absolute;
    font-size: 12px;
    top: -8px;
    right: -8px;
    padding: 4px;
    background-color: red;
    border-radius: 25px;
}

/* User actions */
.user-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}

.user-actions .logged-in span {
    margin-right: 10px;
}

.logged-in {
    display: flex;
    gap: 8px;
    align-items: center;
}
</style>
