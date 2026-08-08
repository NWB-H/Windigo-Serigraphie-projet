<template>
    <div>
        <h2 class="mb-4">Contact</h2>
        <form @submit.prevent="onSubmit">
            <div class="mb-3">
                <label for="email" class="form-label">Adresse email</label>
                <input v-model="form.email" type="email" class="form-control" id="email"
                    placeholder="name@example.com" />
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Demande</label>
                <textarea v-model="form.message" class="form-control" id="message" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-outline-secondary">
                Envoyer
            </button>
        </form>
    </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { contactFormStore } from '@/actions/App/Http/Controllers/ContactFormController';
import { contactFormStore } from '@/actions/App/Http/Controllers/ContactFormController';


const form = useForm(
    contactFormStore().method,
    contactFormStore().url,
    {
        email: '',
        message: '',
    }
);

function onSubmit() {
    form.submit({
        onSuccess: () => {

        },
    });
}
</script>

<style scoped></style>
