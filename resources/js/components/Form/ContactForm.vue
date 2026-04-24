<template>
    <div>
        <h2 class="mb-4">Contact</h2>
        <form @submit.prevent="onSubmit">
            <div class="mb-3">
                <label for="email" class="form-label">Adresse email</label>
                <input
                    v-model="form.email"
                    type="email"
                    class="form-control"
                    id="email"
                    placeholder="name@example.com"
                />
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Demande</label>
                <textarea
                    v-model="form.message"
                    class="form-control"
                    id="message"
                    rows="3"
                ></textarea>
            </div>
            <button type="submit" class="btn btn-outline-secondary">
                Envoyer
            </button>
        </form>
    </div>
</template>

<script setup lang="ts">
import { useNotificationStore } from '@/stores/Notifications';
import { ref } from 'vue';

const { addItem } = useNotificationStore();

const form = ref({
    email: '',
    message: '',
});

function onSubmit() {
    addItem({ type: 'success', message: 'Hello world !' });
}
</script>

<style scoped></style>
