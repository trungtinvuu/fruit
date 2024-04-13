<script lang="ts">
import { RouterView } from 'vue-router';
import MainView from './Main.vue';
import { mapActions, mapGetters } from 'vuex';
import axiosInstance from '@/store/axiosInstance';
import Config from '@/store/config';

export default {
  components: {
    MainView,
    RouterView
  },
  computed: {
    ...mapGetters(['getInfoUser', 'isLoggedIn'])
  },
  methods: {
    ...mapActions(['setupInfoUser', 'setLoginStatus']),
    async fetchUser() {
        try {
            const response = await axiosInstance.post(Config.API_ENDPOINT+'/info');
            this.setupInfoUser(response.data);
            this.setLoginStatus(true);
        } catch (error) {

        }
    },
  },
  mounted() {
    this.fetchUser();
  }
}
</script>

<template>
    <v-locale-provider v-if="isLoggedIn" >
        <v-app>
            <MainView />
            <v-main>
                <v-container fluid class="page-wrapper">
                    <div class="maxWidth">
                        <RouterView />
                    </div>
                </v-container>
            </v-main>
        </v-app>
    </v-locale-provider>
</template>
