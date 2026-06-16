<template>
    <button
        type="submit"
        v-bind="$attrs"
        :class=" !ignoreStyle ? 'button button--' + type : ''"
        :disabled="loading || disabled"
    >
        <slot></slot>
    </button>
</template>

<script setup lang="ts">
defineOptions({ inheritAttrs: false });

type ButtonTypes = 'default' | 'cancel';

const {
    loading = false,
    disabled = false,
    type = 'default',
    ignoreStyle = false,
} = defineProps<{
    loading?: boolean;
    disabled?: boolean;
    type?: ButtonTypes;
    ignoreStyle?: boolean;
}>();
</script>

<style scoped lang="scss">
.button {
    width: 100%;
    border-radius: 0.25rem;
    background-color: #a78770;
    padding: 0.5rem 1.5rem;
    font-weight: 600;
    color: #ffffff;
    box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    transition: all 0.2s ease;

    &:hover {
        background-color: #96715b;
    }

    &:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgb(167 135 112 / 0.4);
    }

    &:active {
        transform: scale(0.97);
        background-color: #8f6e58;
    }

    &--cancel {
        background-color: #8b8178;
        color: #ffffff;

        &:hover {
            background-color: #756c64;
        }

        &:focus {
            box-shadow: 0 0 0 2px rgb(139 129 120 / 0.4);
        }

        &:active {
            background-color: #6b625b;
        }
    }

    &--delete {
        background-color: #c75d5d;
        color: #ffffff;

        &:hover {
            background-color: #b84d4d;
        }

        &:focus {
            box-shadow: 0 0 0 2px rgb(199 93 93 / 0.4);
        }

        &:active {
            background-color: #a94444;
        }
    }

    &--disabled,
    &:disabled {
        background-color: #d1d5db;
        color: #6b7280;
        cursor: not-allowed;
        opacity: 0.7;
        box-shadow: none;
        transform: none;
    }

    &--disabled:hover,
    &:disabled:hover {
        background-color: #d1d5db;
    }
}
</style>
