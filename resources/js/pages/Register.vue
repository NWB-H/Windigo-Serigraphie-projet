<template>
    <div class="top-container">
        <form @submit.prevent="form.post(route('register.store'))">
            <div class="register__container">
                <h2 class="register__title">Inscription</h2>
                <div class="register__content">
                    <AppInput
                        v-model="form.name"
                        :error="form.errors.name"
                        type="text"
                        inputContainerClass="bg"
                        placeholder="Nom"
                        id="name"
                    />

                    <AppInput
                        v-model="form.email"
                        :error="form.errors.email"
                        type="text"
                        inputContainerClass="bg"
                        placeholder="Email"
                        id="email"
                    />

                    <AppPassword
                        v-model="form.password"
                        :error="form.errors.password"
                        inputContainerClass="bg"
                        placeholdder="Mot de passe"
                    />

                    <AppInput
                        v-model="form.password_confirmation"
                        :error="form.errors.password_confirmation"
                        type="password"
                        inputContainerClass="bg"
                        placeholder="Confirmer le mot de passe"
                        id="password_confirmation"
                    />

                    <div class="register__action">
                        <AppButton :loading="loading">{{
                            loading ? 'Inscription en cours...' : "S'inscrire"
                        }}</AppButton>
                    </div>

                    <p class="register__footer">
                        Déjà inscrit ?
                        <Link :href="route('login')">Connectez-vous</Link>
                        <Link :href="route('forgot-password')"
                            >Mot de passe oublié ?</Link
                        >
                    </p>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import AppInput from '@/components/Global/AppInput.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppButton from '@/components/Global/AppButton.vue';
import AppPassword from '@/components/Global/AppPassword.vue';

defineOptions({
    layout: [AppLayout, { title: 'Inscription' }],
});

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
});

const loading = ref(false);
</script>

<style lang="scss" scoped>
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
    &__container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        border-radius: 5px;
        background-color: #d2baaa;
        padding: 1vw 2vw;
    }

    &__title {
        text-align: center;
        font-size: 2.5em;
        font-weight: bold;
        color: #a78770;
        margin-bottom: 1em;
    }

    &__action {
    }

    &__footer {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }
}

.container-champ {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: relative;
}

.error {
    color: #b00020;
    font-size: 0.9em;
    margin-top: 0.25em;
}
</style>
