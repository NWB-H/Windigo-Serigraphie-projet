<template>
    <span :class="type">
        {{ message }}
    </span>
</template>

<script setup lang="ts">
defineProps<{ message: string; type: string }>();
</script>

<style scoped>
span {
    border-radius: 4px;
    padding: 18px;
    color: white;
}

.success {
    background-color: #0a3622;
}

.error {
    background-color: darkred;
}

.warning {
    background-color: darkorange;
}
</style>
