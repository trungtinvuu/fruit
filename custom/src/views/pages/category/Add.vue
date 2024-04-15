<template>
    <v-container>
        <v-breadcrumbs :items="['Category', 'Add']" class="custom-breadcrumb" color="primary"></v-breadcrumbs>
        <v-form @submit.prevent="submitForm" ref="form">
            <v-row>
                <v-col cols="12" >
                    <div class="text-subtitle-1 text-medium-emphasis">
                        <strong>Caterogy name</strong>
                    </div>
                    <br>
                    <v-text-field 
                        v-model="textInput"
                        required
                        :rules="textInputRules"
                        density="compact"
                        variant="solo"
                        single-line
                        placeholder="Name"
                    >
                    </v-text-field>
                </v-col>
                <v-col cols="12" >
                    <div class="text-subtitle-1 text-medium-emphasis">
                        <strong>Caterogy parent</strong>
                    </div>
                    <br>
                    <v-select
                        v-model="selectedItem"
                        :items="options"
                        :item-title="(item) => render(item.level) + item.name"
                        item-value="id"
                        density="compact"
                        variant="solo"
                        color="primary"
                        class="custom-select"
                    ></v-select>
                </v-col>
                <v-col cols="12" >
                    <v-btn type="submit" color="primary">Add category</v-btn>
                </v-col>
            </v-row>
        </v-form>
        <v-snackbar 
            v-model="showSuccessSnackbar" 
            color="success"
            :timeout="1000"
        ><b>Add successfully!</b></v-snackbar>
    </v-container>
</template>

<script>
import { ref } from 'vue';
import { myMixin } from '@/store/mixin';
import axiosInstance from '@/store/axiosInstance';
import Config from '@/store/config';

export default {
    mixins: [myMixin],
    data() {
        return {
            textInput: '',
            selectedItem: null,
            showSuccessSnackbar: false,
            options: [{ name: 'Root category', id: null }],
        };
    },
    methods: {
        fetchData() {
            axiosInstance.get(Config.API_ENDPOINT + '/category')
            .then(response => {
                let data = response.data
                this.options = this.options.slice(0, 1).concat(data);
                
            })
            .catch(error => {
                console.error('Error deleting category:', error);
            });
        },
        async submitForm() {
            const { valid } = await this.$refs.form.validate();
            if(valid){
                const data = {
                    name : this.textInput.trim(),
                    parent_id : this.selectedItem,
                };
                axiosInstance.post(Config.API_ENDPOINT + '/category' , data)
                    .then(response => {
                        this.textInput = [];
                        this.selectedItem = null;
                        this.fetchData();
                        this.showSuccessSnackbar = true;
                    })
                    .catch(error => {
                        console.error('Error deleting category:', error);
                    });
            }
        }
    },
    created() {
        this.fetchData();
    },
    computed: {
        textInputRules() {
            return [
                value => !!value.trim() || 'Name is required',
            ];
        }
    }
};
</script>
