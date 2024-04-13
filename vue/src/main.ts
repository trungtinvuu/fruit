import { createApp } from 'vue';
import App from './App.vue';
import vuetify from './plugins/vuetify';
import '@/scss/style.scss';
import PerfectScrollbar from 'vue3-perfect-scrollbar';
import VueApexCharts from 'vue3-apexcharts';
import VueTablerIcons from 'vue-tabler-icons';
import Maska from 'maska';
import store from './store';
import router  from '@/router';

const app = createApp(App);
app.use(router);
app.use(PerfectScrollbar);
app.use(VueTablerIcons);
app.use(Maska);
app.use(store);
app.use(VueApexCharts);
app.use(vuetify).mount('#app');
