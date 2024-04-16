<template>
    <v-container>
        <v-breadcrumbs :items="breadcrumbs" class="custom-breadcrumb" color="primary"></v-breadcrumbs>
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
                        :item-value="(item) => item"
                        density="compact"
                        variant="solo"
                        color="primary"
                        class="custom-select"
                    ></v-select>
                </v-col>
                <v-col cols="12" >
                    <v-btn type="submit" color="primary">Edit category</v-btn>
                </v-col>
            </v-row>
        </v-form>
        <v-snackbar 
            v-model="showSuccessSnackbar" 
            color="success"
            :timeout="1000"
        ><b>Edit successfully!</b></v-snackbar>
    </v-container>
</template>

<script>
import { ref } from 'vue';
import { myMixin } from '@/store/mixin';
import axiosInstance from '@/store/axiosInstance';
import Config from '@/store/config';
import { ValidationRules } from '@/store/utils';

export default {
    mixins: [myMixin],
    data() {
        return {
            textInput: '',
            category : {},
            id : null,
            selectedItem: null,
            showSuccessSnackbar: false,
            options: [{ name: 'Root category', id: null }],
            textInputRules: [],
            breadcrumbs: []
        };
    },
    methods: {
        fetchCategory() {
            axiosInstance.get(Config.API_ENDPOINT + '/category/' + this.id)
                .then(response => {
                    console.log(response.data);
                    this.category = response.data;
                    this.textInput = this.category.name;
                    this.breadcrumbs = ['Category', 'Edit', this.category.name];
                })
                .catch(error => {
                    console.error('Error deleting category:', error);
                });
        },
        fetchData() {
            axiosInstance.get(Config.API_ENDPOINT + '/categoryDetail/' + this.id)
            .then(response => {
                let data = response.data
                this.options = this.options.slice(0, 1).concat(data);
                this.options.forEach((option, index) => {
                    if(this.category.parent_id === option.id){
                        this.selectedItem = this.options[index];
                    }
                });
            })
            .catch(error => {
                console.log(error);
            });
        },
        async submitForm() {
            const { valid } = await this.$refs.form.validate();
            if(valid){
                const data = {
                    name : this.textInput.trim(),
                    parent_id : this.selectedItem.id,
                };
                console.log(data);
                axiosInstance.put(Config.API_ENDPOINT + '/category/' + this.id, data)
                    .then(response => {
                        this.fetchCategory();
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
        this.id = this.$route.params.id;
        this.textInputRules = ValidationRules.textRule();
        this.fetchCategory();
        this.fetchData();
    }
};
</script>
