<template>
    <div class="form-group">
        <input
            v-model="model"
            v-bind="$attrs"
        />
    </div>
</template>

<script setup lang="ts">
const model = defineModel()
</script>

<style scoped>

</style>
