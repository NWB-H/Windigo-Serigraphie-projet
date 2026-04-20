<template>
    <AppInput
        type="password"
        class="input"
        placeholder="Mot de passe"
        v-model="model"
        :error="error"
        @input="validInput"
    />
</template>

<script setup lang="ts">
import AppInput from "@/components/Global/AppInput.vue";

const model = defineModel()

defineProps<{ error?: string }>()

function validInput() {
    console.log('valid input')
}
</script>

<style scoped>

</style>
