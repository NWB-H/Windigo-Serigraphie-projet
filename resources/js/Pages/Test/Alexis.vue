<template>
    <div>
        <Head title="Welcome" />
        <h1>Welcome</h1>
        <p>Hello {{ userName }}, welcome to your first Inertia app!</p>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'

defineProps({ userName: string })
</script>
