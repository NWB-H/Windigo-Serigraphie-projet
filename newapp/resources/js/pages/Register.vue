
<template>
    <AppLayout>
        <div class="top-container">
            <form @submit.prevent="form.post(route('register.store'))">
                <div class="register">
                    <h2 class="form-title">Inscription</h2>
                    <div class="container-champ">
                        <AppInput
                            v-model="form.name"
                            type="text"
                            class="input"
                            placeholder="Nom"
                            id="name"
                        />
                        <div
                            v-if="form.errors.name"
                            class="error"
                        >{{ form.errors.name }}</div>

                        <AppInput
                            v-model="form.email"
                            type="text"
                            class="input"
                            placeholder="Email"
                        />
                        <div
                            v-if="form.errors.email"
                            class="error"
                        >{{ form.errors.email }}</div>

                        <AppInput
                            type="password"
                            class="input"
                            v-model="form.password"
                            placeholder="Mot de passe"
                        />
                        <div
                            v-if="form.errors.password"
                            class="error"
                        >{{ form.errors.password }}</div>

                        <AppInput
                            type="password"
                            class="input"
                            v-model="form.password_confirmation"
                            placeholder="Confirmer le mot de passe"
                        />
                        <div
                            v-if="form.password_confirmation"
                            class="error"
                        >{{ form.errors.password_confirmation }}</div>

                        <div class="form-group">
                            <button type="submit" class="button" :disabled="loading">
                                {{ loading ? 'Envoi...' : 'Créer un compte' }}
                            </button>
                        </div>

                        <p class="register">
                            Déjà inscrit ?
                            <Link :href="route('login')">Connectez-vous</Link>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AppInput from "@/components/Global/AppInput.vue";

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
})

const loading = ref(false)
</script>

<style scoped>
.top-container {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 3vw 2vw;
    flex-direction: row;
    gap: 3vw;
}

.register {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    background-color: #d2baaa;
    padding: 2vw 2vw;
}

.form-title {
    text-align: center;
}

.button {
    width: fit-content;
    padding: 0 1vw;
    height: 2.3em;
    margin: 0.5em;
    background: white;
    color: #a78770;
    border: none;
    border-radius: 0.625em;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
    position: relative;
    z-index: 1;
    overflow: hidden;
}

button:hover {
    color: white;
}

button:after {
    content: "";
    background: black;
    position: absolute;
    z-index: -1;
    left: -20%;
    right: -20%;
    top: 0;
    bottom: 0;
    transform: skewX(-45deg) scale(0, 1);
    transition: all 0.5s;
}

button:hover:after {
    transform: skewX(-45deg) scale(1, 1);
    transition: all 0.5s;
}

.container-champ {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: relative;
    gap: 2vw;
}

.error {
    color: #b00020;
    font-size: 0.9em;
    margin-top: 0.25em;
}
</style>

