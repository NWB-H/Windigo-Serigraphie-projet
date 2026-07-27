<template>
    <div>
        <AppInput
            v-model="model"
            :error="error"
            @input="handleInput"
            :inputContainerClass="inputContainerClass"
            type="password"
            placeholder="Mot de passe"
            id="password"
        />
        <p class="loader">
            <span
                class="loaded"
                :class="{
                    'loaded--none': loadedWidth === 0,
                    'loaded--error': loadedWidth > 0 && loadedWidth < 50,
                    'loaded--warning': loadedWidth >= 50 && loadedWidth < 100,
                    'loaded--success': loadedWidth === 100,
                }"
                :style="{ width: `${loadedWidth}%` }"
            ></span>
        </p>
        <ul>
            <li v-for="rule in rulesFailed" :key="rule">{{ rule }}</li>
        </ul>
    </div>
</template>

<script setup lang="ts">
import AppInput from '@/components/Global/AppInput.vue';
import { computed, ref } from 'vue';

const model = defineModel<string>();

defineProps<{ error?: string; inputContainerClass?: string }>();

const emits = defineEmits<{ (e: 'password:valid', isValid: boolean): void }>();

const rules = [
    (value: string) => !!value || 'Le mot de passe est requis',
    (value: string) =>
        value.length >= 8 ||
        'Le mot de passe doit contenir au moins 8 caractères',
    (value: string) =>
        /[A-Z]/.test(value) ||
        'Le mot de passe doit contenir au moins une lettre majuscule',
    (value: string) =>
        /[a-z]/.test(value) ||
        'Le mot de passe doit contenir au moins une lettre minuscule',
    (value: string) =>
        /[0-9]/.test(value) ||
        'Le mot de passe doit contenir au moins un chiffre',
    (value: string) =>
        /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(value) ||
        'Le mot de passe doit contenir au moins un caractère spécial',
];

const rulesFailed = ref<string[]>([]);
const loadedWidth = computed(() => {
    if (!model.value) {
        return 0;
    }
    return ((rules.length - rulesFailed.value.length) * 100) / rules.length;
});

function handleInput(event: Event) {
    rulesFailed.value = [];
    const value = (event.target as HTMLInputElement).value;

    if (!value) {
        return;
    }

    rules.forEach((rule) => {
        const result = rule(value);
        if (typeof result === 'string') {
            rulesFailed.value.push(result);
        }
    });

    emits('password:valid', rulesFailed.value.length === 0);
}
</script>

<style lang="scss" scoped>
.loader {
    width: 100%;
    height: 10px;
    border-radius: 10px;
    background-color: rgb(199 198 198 / 0.82);
    overflow: hidden;
    margin-bottom: 4px;

    .loaded {
        display: block;
        height: 100%;
        background-color: red;
        width: 0;
        transition:
            width 0.3s ease,
            background-color 0.3s ease;

        &--error {
            background-color: red;
        }

        &--none {
            background-color: transparent;
        }

        &--warning {
            background-color: yellow;
        }

        &--success {
            background-color: green;
        }
    }
}

ul {
    padding: 0;

    li {
        font-size: 12px;
        color: red;
    }
}
</style>
