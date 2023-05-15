<template>
    <div>
        <h1>Test Component {{ name }}</h1>
    </div>
</template>

<script setup>
    defineProps({
        name: {
            type: String,
            required: true
        }
    });
</script>

<style scoped>

</style>