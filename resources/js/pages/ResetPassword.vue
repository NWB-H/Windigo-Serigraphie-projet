<template>
    <div class="top-container">
        <form @submit.prevent="handleSubmit">
            <div class="card__container bg">
                <h2 class="card__title text">Nouveau mot de passe</h2>
                <div class="card__content">
                    <AppPassword
                        v-model="form.password"
                        :error="form.errors.password"
                        @password:valid="isPasswordValid = $event"
                        placeholder="Nouveau mot de passe"
                        id="password"
                        inputContainerClass="bg"
                    />
                    <AppInput
                        v-model="form.password_confirmation"
                        :error="form.errors.password_confirmation"
                        type="password"
                        label="confirm"
                        id="confirm"
                        placeholder="Confirmer le mot de passe"
                        inputContainerClass="bg"
                    />
                    <AppButton :disabled="!isPasswordValid">Envoyer</AppButton>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import AppButton from '@/components/Global/AppButton.vue';
import { useForm } from '@inertiajs/vue3';
import AppPassword from '@/components/Global/AppPassword.vue';
import { ref } from 'vue';
import AppInput from '@/components/Global/AppInput.vue';

defineOptions({
    layout: [AppLayout, { title: 'Nouveau mot de passe' }],
});

const props = defineProps<{ formUrl: string }>();

const form = useForm<{
    password: string | null;
    password_confirmation: string | null;
}>('post', props.formUrl, {
    password: null,
    password_confirmation: null,
});

const isPasswordValid = ref(false);

function handleSubmit() {
    if (!isPasswordValid.value) {
        return;
    }

    form.submit({
        onSuccess: () => {
            form.reset('password');
        },
    });
}
</script>

<style scoped lang="scss">
@use '@css/card.scss';
</style>
