<template>
    <v-select 
        v-model="selectedMenu"
        :items="menu"
        label="Select category"
        :item-title="(item) => formattedName(item) + item.name"
        item-value="id"
    >
    </v-select>
    <div>{{ selectedMenu }}</div>
</template>

<script>
import axiosInstance from '@/store/axiosInstance';
import Config from '@/store/config';
import { myMixin } from '@/store/mixin';

export default {
    mixins: [myMixin],
    data() {
        return {
            id : null,
            menu : [],
            selectedMenu: null,
        };
    },
    methods: {
        formattedName(item) {
            let level = item.level;
            let result = this.render(level);
            return result;
        }
    },
    mounted() {
        this.id = this.$route.params.id;
        console.log(this.id);
        axiosInstance.get(Config.API_ENDPOINT + '/categoryDetail/' + this.id)
          .then(response => {
            this.menu = response.data
          })
          .catch(error => {
            console.error('Error deleting category:', error);
          });
    }
};
</script>
