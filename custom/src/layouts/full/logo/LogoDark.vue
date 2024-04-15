<template>
    <div class="logo">
        <RouterLink to="/">
            <img src="/src/assets/images/logos/logo.png" alt="logo" style="max-width: 100%;" >
        </RouterLink>
    </div>
</template>
<script setup lang="ts">
import { ref } from 'vue';
import { RouterLink } from 'vue-router';
const primary = ref('rgb(var(--v-theme-primary))');
const secondary = ref('rgb(var(--v-theme-secondary))');
</script>
