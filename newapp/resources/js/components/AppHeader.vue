<template>
    <header class="sticky-header">
        <div class="header-container">
            <Link :href="route('home')" class="logo">
                <img src="/images/logo.png" alt="Logo Windigo" />
            </Link>

            <nav class="nav-links">
                <Link :href="route('shop')">BOUTIQUE</Link>
                <Link href="/ateliers">ATELIERS</Link>
                <Link :href="route('portfolio')">PORTFOLIO</Link>
                <Link :href="route('about')">A PROPOS</Link>
            </nav>

            <div class="user-actions">
                <div v-if="isLogged" class="logged-in">
                    <span>Bienvenue {{ user.email }}</span>
                    <Link v-if="user && user.role === 'ROLE_ADMIN'" href="/admin" class="btn btn-warning">Panel Admin</Link>

                    <button type="button" class="btn btn-outline-secondary" @click="logout">Déconnexion</button>
                </div>
                <Link href="/panier" v-if="totalCartItem > 0">
                    <p class="cart bg-secondary">Panier <span class="badge-cart">{{ totalCartItem }}</span></p>
                </Link>
                <Link v-if="!isLogged" :href="route('login')" class="btn btn-outline-secondary">
                    <img src="/images/account.svg" alt="Login" />
                </Link>
            </div>
        </div>
    </header>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import { useCartStore } from "@/stores/Cart";
import { storeToRefs } from "pinia";

const isLogged = ref(false)

const { items, totalCartItem } = storeToRefs(useCartStore())
</script>

<style scoped>
header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background: #A88871;
    z-index: 1000;
    display: flex;
    justify-content: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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
    content: "";
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

</style>
