<template>
    <AppLayout title="Mot de passe oublié">
        <div class="top-container">
            <form @submit.prevent="handleSubmit">
                <div class="card__container bg">
                    <h2 class="card__title text">Mot de passe oublié</h2>
                    <div class="card__content">
                        <AppInput
                            v-model="form.email"
                            :error="form.errors.email"
                            inputContainerClass="bg"
                            type="email"
                            placeholder="Votre adresse email"
                            id="email"
                        />

                        <AppButton>Envoyer</AppButton>
                    </div>
                    <p class="card__footer">
                        Déjà inscrit ?
                        <Link :href="route('login')">Connectez-vous</Link>
                        <Link :href="route('register')"
                            >Pas encore de compte ?</Link
                        >
                    </p>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import AppInput from '@/components/Global/AppInput.vue';
import AppButton from '@/components/Global/AppButton.vue';
import { forgotPasswordStore } from '@/actions/App/Http/Controllers/SecurityController';

const form = useForm<{ email: string | null }>(
    forgotPasswordStore().method,
    forgotPasswordStore().url,
    {
        email: null,
    },
);

function handleSubmit() {
    form.submit({
        onSuccess: () => {
            form.reset('email');
        },
    });
}
</script>

<style lang="scss" scoped>
@use '@css/card.scss';
</style>
