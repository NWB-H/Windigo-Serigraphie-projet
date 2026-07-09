<template>
    <form @submit.prevent="handleSubmit" class="flex flex-col gap-2">
            <div id="stripe"></div>
            <AppButton
                class="flex w-100 justify-center rounded bg-[#a78770] px-6 py-2 font-semibold text-white shadow-sm transition hover:bg-[#8f6e58] focus:ring-2 focus:ring-[#8f6e58]/40 focus:outline-none active:scale-95 disabled:cursor-not-allowed disabled:opacity-50"
            >
                <AppLoader v-if="loading" />
                <template v-else> Payer </template>
            </AppButton>
        </form>
</template>

<script setup lang="ts">
import { loadStripe, StripeElements } from '@stripe/stripe-js';
import { onMounted, ref  } from 'vue';
import AppButton from '@/components/Global/AppButton.vue';
import { Stripe } from '@stripe/stripe-js';
import AppLoader from '@/components/Global/AppLoader.vue';
import { router } from '@inertiajs/vue3';
import AppLayout from "@/layouts/AppLayout.vue";

defineOptions({
    layout: [AppLayout, { title: 'Paiement' }],
})
const props = defineProps<{ clientSecret: string, clientPublic: string }>();

const ready = ref(false);
const loading = ref(false);

let stripe: Stripe | null = null;
let elements: StripeElements | null = null;

async function handleSubmit() {
    if (!stripe || !elements) {
        return;
    }

    loading.value = true;

    try {
        const response = await stripe.confirmPayment({
            elements,
            redirect: 'if_required',
        });

        if ('succeeded' === response.paymentIntent?.status) {
            router.flash('notification', {
                type: 'success',
                message: 'Paiement effectué avec succès',
            }); // voir pourquoi on a plein d'appel
        }
    } catch {
        router.flash('notification', {
            type: 'error',
            message: 'Une erreur est survenue.',
        });
    }

    loading.value = false;
}

onMounted(async () => {
    stripe = await loadStripe(props.clientPublic);

    if (!stripe) {
        return;
    }

    elements = stripe.elements({
        clientSecret: props.clientSecret,
    });

    const paymentElement = elements.create(
        'payment',
        {
            fields: {
                billingDetails: 'never'
            }
        }
    );

    paymentElement.on('ready', () => {
        ready.value = true;
    });

    paymentElement.mount('#stripe');
});
</script>

<style scoped>
#stripe {
    width: 500px;
}
</style>
