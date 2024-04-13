<script setup lang="ts">
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { router } from '@/router';
import { Form } from 'vee-validate';

const emailRules = [
  (value: string) => !!value || 'Email is required.',
  (value: string) => /\S+@\S+\.\S+/.test(value) || 'Must be in email format.'
];

const pwRules = [
  (value: string) => !!value || 'Password is required.',
  (value: string) => (value && value.length >= 6) || 'Password must be at least 6 characters long.'
];

const credentials = ref({
  email: '',
  password: '',
});

const loginForm = ref(null);
// const loginForm = ref< >(null);
const message = ref('')

const login = async () => {
  const { valid } = await loginForm.loginForm.validate();
  console.log(loginForm.value);
  if (loginForm.value) {
    // loginForm.value.validate().then(valid => {
    //       if (valid) {
    //         // Nếu form hợp lệ, tiến hành xử lý đăng nhập
    //         console.log('Form is valid');
    //       } else {
    //         // Nếu form không hợp lệ, hiển thị thông báo hoặc thực hiện các hành động khác
    //         console.log('Form is invalid');
    //       }
    //     });
  }
  // loginForm.value.validate().then(valid => {
  //   if (valid) {
  //     console.log('Form is valid');
  //   } else {
  //     console.log('Form is invalid');
  //   }
  // });

  // const {valid, errors} = await loginForm.value.validate();
  // const { valid } = await this.$refs.loginForm.validate();
  // try {
  //   const response = await axios.post('http://127.0.0.1:8000/api/login', credentials.value);
  //   localStorage.setItem('access_token', response.data.token);
  //   // router.push('/sample-page');
  //   alert("test");
  // } catch (error : any) {
  //   if (error.response && error.response.data) {
  //     let data = error.response.data;
  //     message.value = data.error;
  //   } else {
  //     console.log(error);
  //   }
  // }
};
</script>

<template>
  <v-form @submit.prevent="login" ref="loginForm">
    <v-row class="d-flex mb-3">
        <v-col cols="12" class="pb-0">
            <v-label class="font-weight-bold mb-1">Email</v-label>
            <v-text-field 
                variant="outlined" 
                color="primary"
                placeholder="Email"
                v-model="credentials.email"
                :rules="emailRules"
            ></v-text-field>
        </v-col>
        <v-col cols="12" class="pb-0">
            <v-label class="font-weight-bold mb-1">Password</v-label>
            <v-text-field 
              variant="outlined" 
              type="password"
              color="primary"
              v-model="credentials.password"
              placeholder="Password"
              :rules="pwRules"
            ></v-text-field>
        </v-col>
        <v-alert v-if="message" dismissible>
          <span class="message">{{ message }}</span>
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
