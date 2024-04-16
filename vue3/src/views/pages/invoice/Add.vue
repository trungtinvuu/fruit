<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12">
                <v-combobox
                    v-model="select"
                    :items="fruits"
                    :item-props="itemProps"
                    item-title="name"
                    label="Search and select fruit"
                    variant="solo"
                    multiple
                >
                </v-combobox>
            </v-col>
        </v-row>
        {{ select }}
    </v-container>
</template>

<script>
import { myMixin } from '@/store/mixin';
import axiosInstance from '@/store/axiosInstance';
import Config from '@/store/config';

export default {
    mixins: [myMixin],
    data() {
        return {
            select: [],
            fruits: [],
        }
    },
    methods: {
      itemProps(item) {
        return {
          title: item.name,
          subtitle: item.unit + " - " + item.price,
        }
      },
    },
    created() {
        this.productList()
                .then(response => {
                    this.fruits = response.data;
                })
                .catch(error => {
                    console.log(error)
                });
    },
}
</script>
