<template>
    <form class="flex flex-col gap-3">
        <div class="flex gap-2">
            <AppInput
                v-model="form.date"
                :error="form.errors.date"
                class="form-control"
                id="session-date"
                type="datetime-local"
                placeholder="Date"
                inputContainerClass="bg-white"
            />

            <AppInput
                v-model="form.capacity"
                :error="form.errors.capacity"
                class="form-control"
                id="capacity"
                placeholder="Nombre de participants"
                inputContainerClass="bg-white w-[200px]"
                min="1"
            />
        </div>

        <AppButton
            type="default"
            :disabled="form.processing"
            class="whitespace-nowrap"
        >
            {{ form.processing ? 'Ajout...' : 'Ajouter une session' }}
        </AppButton>
    </form>
</template>

<script setup lang="ts">
import {useForm} from "@inertiajs/vue3";
import AppInput from "@/components/Global/AppInput.vue";
import AppButton from "@/components/Global/AppButton.vue";

const form = useForm(
    'post',
    '',
    {
        capacity: 0,
        date: '',
    }
);
</script>

<style scoped>

</style>
