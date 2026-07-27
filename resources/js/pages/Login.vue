<template>
    <div class="top-container">
        <div class="login">
            <form @submit.prevent="form.post(route('login.store'))">
                <h2 class="form-title">Connexion</h2>
                <div class="container-champ">
                    <div class="w-[200px]">
                        <AppInput
                            v-model="form.email"
                            :error="form.errors.email"
                            inputContainerClass="bg"
                            type="text"
                            placeholder="Email"
                            id="email"
                        />
                    </div>
                    <div class="w-[200px]">
                        <AppInput
                            v-model="form.password"
                            :error="form.errors.password"
                            inputContainerClass="bg"
                            type="password"
                            placeholder="Mot de passe"
                            id="password"
                        />
                    </div>
                    <div>
                        <AppButton>Connexion</AppButton>
                    </div>
                    <p class="register">
                        Vous n'avez pas encore de compte ?
                        <Link :href="route('register')"> Inscrivez-vous </Link>
                    </p>
                    <Link :href="route('forgot-password')"
                        >Mot de passe oublié ?</Link
                    >
                </div>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import AppInput from '@/components/Global/AppInput.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import AppButton from '@/components/Global/AppButton.vue';

defineOptions({
    layout: [AppLayout, { title: 'Connexion' }],
});
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

.container-champ {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: relative;
}
</style>
