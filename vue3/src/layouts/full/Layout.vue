<script>
import FullLayout from './FullLayout.vue';
import { mapActions, mapGetters } from 'vuex';
import axiosInstance from '@/store/axiosInstance';
import Config from '@/store/config';

export default {
  components: {
    FullLayout
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
    <v-locale-provider >
        <v-app>
            <FullLayout />
        </v-app>
    </v-locale-provider>
</template>
