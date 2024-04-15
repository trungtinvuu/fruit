<script setup lang="ts">
import { RouterView } from 'vue-router';
import MainView from './Main.vue';
</script>

<template>
    <MainView />
    <v-main>
        <v-container fluid class="page-wrapper">
            <div class="maxWidth">
                <RouterView />
            </div>
        </v-container>
    </v-main>
</template>
