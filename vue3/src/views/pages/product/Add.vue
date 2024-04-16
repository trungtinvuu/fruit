<template>
    <v-container>
        <v-breadcrumbs :items="['Product', 'Add']" class="custom-breadcrumb" color="primary"></v-breadcrumbs>
        <v-form @submit.prevent="submitForm" ref="form">
            <v-row>
                <v-col cols="12" >
                    <div class="text-subtitle-1 text-medium-emphasis">
                        <strong>Product name</strong>
                    </div>
                    <br>
                    <v-text-field
                        v-model="textInput"
                        required
                        :rules="ruleText"
                        density="compact"
                        variant="solo"
                        single-line
                        placeholder="Name"
                    >
                    </v-text-field>
                </v-col>
                <v-col cols="12" >
                    <div class="text-subtitle-1 text-medium-emphasis">
                        <strong>Product category</strong>
                    </div>
                    <br>
                    <v-select
                        v-model="selectedItem"
                        :items="options"
                        :item-title="(item) => render(item.level) + item.name"
                        :rules="[v => !!v || 'Item is required']"
                        item-value="id"
                        required
                        label="Select category"
                        density="compact"
                        variant="solo"
                        color="primary"
                        class="custom-select"
                    ></v-select>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="6" >
                    <div class="text-subtitle-1 text-medium-emphasis">
                        <strong>Product Unit</strong>
                    </div>
                    <br>
                    <v-text-field
                        v-model="unitInput"
                        required
                        :rules="ruleText"
                        density="compact"
                        variant="solo"
                        single-line
                        placeholder="Unit"
                    >
                    </v-text-field>
                </v-col>
                <v-col cols="6" >
                    <div class="text-subtitle-1 text-medium-emphasis">
                        <strong>Product Price (Ex : 0.5, 1)</strong>
                    </div>
                    <br>
                    <v-text-field
                        v-model="priceInput"
                        required
                        :rules="rulePrice"
                        density="compact"
                        variant="solo"
                        single-line
                        placeholder="Price"
                    >
                    </v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" >
                    <v-btn type="submit" color="primary">Add product</v-btn>
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
import { ValidationRules } from '@/store/utils';

export default {
    mixins: [myMixin],
    data() {
        return {
            textInput: '',
            unitInput: '',
            priceInput: null,
            selectedItem: null,
            showSuccessSnackbar: false,
            options: [],
            ruleText: [],
            rulePrice: []
        };
    },
    methods: {
        fetchData() {
            this.categoryList()
                .then(response => {
                    this.options = response.data;
                })
                .catch(error => {
                    console.log(error)
                });
        },
        createProduct(data) {
            axiosInstance.post(Config.API_ENDPOINT + '/product' , data)
                    .then(response => {
                        this.showSuccessSnackbar = true;
                        this.$refs.form.reset();
                    })
                    .catch(error => {
                        console.error('Error deleting category:', error);
                    });
        },
        async submitForm() {
            const { valid } = await this.$refs.form.validate();
            if(valid){
                const data = {
                    category_id : this.selectedItem,
                    name : this.textInput.trim(),
                    unit: this.unitInput,
                    price: this.priceInput
                }
                this.createProduct(data);
            }
        }
    },
    created() {
        this.ruleText = ValidationRules.textRule();
        this.rulePrice = ValidationRules.priceRule();
        this.fetchData();
    }
};
</script>
