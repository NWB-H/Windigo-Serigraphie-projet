<template>
    <div>
        <Resume :workshop />
        <form class="px-6 py-7 md:px-8 md:py-8" @submit.prevent="handleFormSubmit">
            <div class="mb-7">
                <h2 class="text-2xl font-bold text-slate-900 md:text-3xl">
                    Planifier une session
                </h2>

                <p class="mt-2 text-sm text-slate-500 md:text-base">
                    Choisissez une date et le nombre de participants pour
                    ajouter une nouvelle session.
                </p>
            </div>

            <div class="grid gap-5 lg:grid-cols-[1fr_1fr_auto] lg:items-end">
                <!-- Date -->
                <AppInput
                    v-model="form.date"
                    :error="form.errors.date"
                    class="h-14 w-full rounded-xl border border-slate-300 bg-white px-4 text-slate-900 transition outline-none hover:border-slate-400 focus:border-[#b28e74] focus:ring-4 focus:ring-[#b28e74]/15"
                    id="session-date"
                    type="datetime-local"
                    placeholder="Date"
                    inputContainerClass="bg-white"
                    containerClass="m-0"
                />

                <!-- Participants -->
                <AppInput
                    v-model="form.capacity"
                    :error="form.errors.capacity"
                    class="h-14 w-full rounded-xl border border-slate-300 bg-white px-4 text-slate-900 transition outline-none hover:border-slate-400 focus:border-[#b28e74] focus:ring-4 focus:ring-[#b28e74]/15"
                    id="capacity"
                    placeholder="Nombre de participants"
                    inputContainerClass="bg-white w-[200px]"
                    min="1"
                    containerClass="m-0"
                />

                <!-- Bouton -->
                <AppButton
                    ignoreStyle
                    type="submit"
                    class="flex h-14 w-full items-center justify-center gap-2 rounded-xl bg-[#b28e74] px-8 font-semibold text-white shadow-sm transition hover:bg-[#9d795f] hover:shadow-md active:scale-[0.98] lg:w-auto lg:min-w-[230px]"
                >
                    <PlusCircleIcon class="h-5 w-5" />
                    Ajouter une session
                </AppButton>
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import Resume from '@/components/WorkshopSession/Resume.vue';
import { Workshop } from '@/models';
import AppInput from '@/components/Global/AppInput.vue';
import { useForm } from '@inertiajs/vue3';
import AppButton from '@/components/Global/AppButton.vue';
import PlusCircleIcon from '@/components/Icon/PlusCircleIcon.vue';
import { sessionStore } from '@/actions/App/Http/Controllers/Auth/WorkshopController';

const props = defineProps<{ workshop: Workshop }>();

const form = useForm(
    sessionStore({ workshop: props.workshop }).method,
    sessionStore({ workshop: props.workshop }).url,
    {
        capacity: 0,
        date: new Date(),
    }
);

function handleFormSubmit()
{
    try {
        form.submit({
            onSuccess: () => {
                form.reset()
            }
        })
    } catch (err) {
        console.log(err)
    }
}
</script>

<style scoped></style>
