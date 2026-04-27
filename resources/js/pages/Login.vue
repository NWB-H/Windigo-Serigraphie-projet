<template>
    <AppLayout title="Connexion">
        <div class="top-container">
            <div class="login">
                <form @submit.prevent="form.post(route('login.store'))">
                    <h2 class="form-title">Connexion</h2>
                    <div class="container-champ">
                        <div class="form-group">
                            <AppInput
                                type="text"
                                class="input"
                                placeholder="Email"
                                v-model="form.email"
                                :error="form.errors.email"
                            />
                        </div>
                        <div class="form-group">
                            <AppInput
                                type="password"
                                class="input"
                                placeholder="Mot de passe"
                                v-model="form.password"
                                :error="form.errors.password"
                            />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="button">
                                Connexion
                            </button>
                        </div>
                        <p class="register">
                            Vous n'avez pas encore de compte ?
                            <Link :href="route('register')">
                                Inscrivez-vous
                            </Link>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppInput from '@/components/Global/AppInput.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: null,
    password: null,
});
</script>

<style scoped>
.top-container {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 3vw 2vw;
    flex-direction: row;
    gap: 3vw;
}

.login {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    border-radius: 5px;
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
    content: '';
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
    -webkit-transition: all 0.5s;
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
</style>
