<template>
    <div
        @mouseover="showTooltip = true"
        @mouseleave="showTooltip = false"
        class="container"
    >
        <p v-if="showTooltip" :class="[direction]" ref="container">
            {{ tooltip }}
        </p>
        <div>
            <slot></slot>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const { direction = 'up' } = defineProps<{
    tooltip: string;
    direction?: 'up' | 'down' | 'left' | 'right';
}>();

const showTooltip = ref(false);
</script>

<style scoped lang="scss">
.container {
    position: relative;

    p {
        position: absolute;
        width: max-content;
        background-color: #333;
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 14px;
        margin: 0;
    }
}

.up {
    left: 50%;
    bottom: calc(100% + 8px);
    transform: translateX(-50%);
}
.down {
    left: 50%;
    top: calc(100% + 8px);
    transform: translateX(-50%);
}

.right {
    left: calc(100% + 8px);
    top: 50%;
    transform: translateY(-50%);
}

.left {
    right: calc(100% + 8px);
    top: 50%;
    transform: translateY(-50%);
}
</style>
