import axios from 'axios';
import Config from './config';
import { router } from '@/router';

const instance = axios.create({
  baseURL: Config.API_ENDPOINT,
});

instance.interceptors.request.use(
  config => {
    const token = localStorage.getItem('access_token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  error => {
    return Promise.reject(error);
  }
);

instance.interceptors.response.use(
  response => {
    return response;
  },
  error => {
    if (error.response && error.response.status === 401) {
      localStorage.removeItem('access_token');
      router.push('/login');
    }
    return Promise.reject(error);
  }
);

export default instance;
