<template>
    <div
        @mouseover="showTooltip = true"
        @mouseleave="showTooltip = false"
        class="container"
    >
        <p v-if="showTooltip">{{ tooltip }}</p>
        <div>
            <slot></slot>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

defineProps<{ tooltip: string }>();

const showTooltip = ref(false);
</script>

<style scoped lang="scss">
.container {
    position: relative;

    p {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        width: max-content;
        transform: translate(-25%, -125%);
        background-color: #333;
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 14px;
    }
}
</style>
