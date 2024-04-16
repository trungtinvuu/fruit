<template>
    <v-container>
        <v-breadcrumbs :items="['Invoice', 'Add']" class="custom-breadcrumb" color="primary"></v-breadcrumbs>
        <v-form @submit.prevent="submitForm" ref="form">
            <v-row>
                <v-col cols="12" sm="6" >
                    <div class="text-subtitle-1 text-medium-emphasis">
                        <strong>Customer name</strong>
                    </div>
                    <br>
                    <v-text-field
                        v-model="textInput"
                        required
                        :rules="ruleText"
                        variant="solo"
                        single-line
                        placeholder="Name"
                    >
                    </v-text-field>
                </v-col>
                <v-col cols="12" sm="6" >
                    <div class="text-subtitle-1 text-medium-emphasis">
                        <strong>Product list</strong>
                    </div>
                    <br>
                    <v-combobox
                        v-model="select"
                        :items="fruits"
                        :item-props="itemProps"
                        item-title="name"
                        :rules="[v => v && v.length > 0 || 'Item is required']"
                        required
                        label="Search and select fruit"
                        variant="solo"
                        multiple
                    >
                    </v-combobox>
                </v-col>
            </v-row>
            <v-row v-if="select.length > 0">
                <v-col cols="12" >
                    <v-table class="product-list" >
                        <thead>
                          <tr>
                            <th class="text-left">No</th>
                            <th class="text-left">Name</th>
                            <th class="text-left">Unit</th>
                            <th class="text-left">Price</th>
                            <th class="text-left">Quantity</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr
                            v-for="(item, index) in select"
                          >
                            <td>{{ displayIndex(index) }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.unit }}</td>
                            <td>{{ item.price }}</td>
                            <td>
                                <input class="quantity" type="number" min="1" value="1" />
                            </td>
                          </tr>
                        </tbody>
                      </v-table>
                </v-col>
            </v-row>
            <v-row>
                <v-number-input
                    control-variant="default"
                    reverse
                ></v-number-input>
                <v-col cols="12" >
                    <v-btn type="submit" color="primary">Add invoice</v-btn>
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
            showSuccessSnackbar: false,
            select: [],
            fruits: [],
            ruleText: [],
        };
    },
    methods: {
        displayIndex(index) {
            return index + 1;
        },
        itemProps(item) {
            return {
                title: item.name,
                subtitle: item.unit + " - " + item.price,
            }
        },
        async submitForm() {
            const { valid } = await this.$refs.form.validate();
            if(valid){  
                alert("ok");
            }
        }
    },
    created() {
        this.ruleText = ValidationRules.textRule();
        this.productList()
                .then(response => {
                    this.fruits = response.data;
                })
                .catch(error => {
                    console.log(error)
                });
    }
};
</script>

<style>
.product-list th, .product-list td{
    border: 1px #eee solid;
}
.quantity{
    padding: 5px;
    width: 50px;
    border: 1px #ccc solid;
    border-radius: 5px;
}
</style>
