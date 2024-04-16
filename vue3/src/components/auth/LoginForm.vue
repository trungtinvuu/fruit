<script>
import axios from 'axios';
import Config from '@/store/config';
import { mapActions, mapGetters } from 'vuex';

export default {
  data() {
    return {
      email: '',
      password: '',
      errorMessage: '',
      emailRules: [
        v => !!v || 'Email is required',
        v => /\S+@\S+\.\S+/.test(v) || 'Email must be valid',
        v => !/\s/.test(v) || 'Email must not contain spaces'
      ],
      passRules: [
        v => !!v || 'Password is required',
        v => !/\s/.test(v) || 'Password must not contain spaces',
        v => v && v.length >= 6 || 'Password must be at least 6 characters',
      ]
    };
  },
  computed: {
    ...mapGetters(['getInfoUser', 'isLoggedIn'])
  },
  methods: {
    ...mapActions(['setupInfoUser', 'setLoginStatus']),
    async login() {
      const { valid } = await this.$refs.form.validate();
      if(valid){
        const credentials = {
          email: this.email,
          password: this.password,
        };
        try {
          const response = await axios.post(Config.API_ENDPOINT+'/login', credentials);
          localStorage.setItem('access_token', response.data.token);
          this.setLoginStatus(true);
          this.$router.push('/');
        } catch (error) {
          if (error.response && error.response.data) {
            let data = error.response.data;
            this.errorMessage = data.error;
          } else {
            console.log(error);
          }
        }
      }
    }
  },
}
</script>

<template>
  <v-form @submit.prevent="login" ref="form">
    <v-row class="d-flex mb-3">
        <v-col cols="12" class="pb-0">
            <v-label class="font-weight-bold mb-1">Email</v-label>
            <v-text-field 
                variant="outlined" 
                color="primary"
                placeholder="Email"
                v-model="email"
                :rules="emailRules"
            ></v-text-field>
        </v-col>
        <v-col cols="12" class="pb-0 pt-0">
            <v-label class="font-weight-bold mb-1">Password</v-label>
            <v-text-field 
              variant="outlined" 
              type="password"
              color="primary"
              v-model="password"
              placeholder="Password"
              :rules="passRules"
            ></v-text-field>
        </v-col>
        <v-alert v-if="errorMessage" class="pb-0 pt-0" dismissible>
          <span class="message">{{ errorMessage }}</span>
        </v-alert>
        <v-col cols="12">
            <v-btn 
              color="primary" 
              size="large" 
              type="submit"
              block
              flat
            >Sign in</v-btn>
        </v-col>
    </v-row>
  </v-form>
</template>

<style>
  .message{
    color: red;
  }
</style>
