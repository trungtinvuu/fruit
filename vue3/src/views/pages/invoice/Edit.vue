<template>
    <v-container v-if="load">
        <v-breadcrumbs :items="breadcrumbs" class="custom-breadcrumb" color="primary"></v-breadcrumbs>
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
                                <input 
                                    v-model="item.quantity"
                                    class="quantity"
                                    type="number" 
                                    min="1"
                                />
                            </td>
                          </tr>
                        </tbody>
                      </v-table>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" >
                    <v-btn type="submit" color="primary">Edit invoice</v-btn>
                </v-col>
            </v-row>
        </v-form>
        <v-snackbar 
            v-model="showSuccessSnackbar" 
            color="success"
            :timeout="1000"
        ><b>Edit successfully!</b></v-snackbar>

        <Invoice :id="id" />
    </v-container>

    <Error404  v-else />
</template>

<script>
import { ref } from 'vue';
import { myMixin } from '@/store/mixin';
import axiosInstance from '@/store/axiosInstance';
import Config from '@/store/config';
import { ValidationRules } from '@/store/utils';
import Error404 from '@/views/pages/Error404.vue';
import Invoice from "@/views/components/Invoice.vue";

export default {
    components: {
        Error404,
        Invoice
    },
    mixins: [myMixin],
    data() {
        return {
            textInput: '',
            showSuccessSnackbar: false,
            select: [],
            fruits: [],
            buy: [],
            ruleText: [],
            breadcrumbs: [],
            id : null,
            invoice : {},
            load: true
        };
    },
    methods: {
        itemProps(item) {
            return {
                title: item.name,
                subtitle: item.unit + " - " + item.price,
            }
        },
        async fetchData() {
            this.invoiceInfo(this.id)
                .then(response => {
                    this.invoice = response.data;
                    this.textInput = this.invoice.customer_name;
                })
                .catch(error => {
                    if(error.response.status===404){
                        this.load = !this.load
                    }
                });
            
            const response = await this.invoiceDetail(this.id);
            this.buy = response.data;

            this.productList()
                .then(response => {
                    const data = response.data;

                    this.fruits = data.map(item => ({
                        id: item.id,
                        name: item.name,
                        unit: item.unit,
                        price: item.price,
                        quantity: 1
                    }));

                    this.select = this.fruits.filter(fruit => 
                        this.buy.some(buyItem => {
                            if (buyItem.id === fruit.id) {
                                fruit.quantity = buyItem.pivot.quantity;
                                return true;
                            }
                            return false;
                        })
                    );
                })
                .catch(error => {
                    console.log(error)
                });
        },
        async submitForm() {
            const { valid } = await this.$refs.form.validate();
            if(valid){
                const data = {
                    customer_name : this.textInput.trim(),
                    products : this.select,
                };
                axiosInstance.put(Config.API_ENDPOINT + '/invoice/' + this.id, data)
                    .then(response => {
                        this.$refs.form.reset();
                        this.showSuccessSnackbar = true;
                        this.fetchData();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        }
    },
    created() {
        this.id = this.$route.params.id;
        this.breadcrumbs = ['Invoice', 'Edit', this.id];
        this.ruleText = ValidationRules.textRule();
        this.fetchData();
    }
};
</script>

<style>
.product-list th, .product-list td{
    border: 1px #eee solid;
}
.quantity{
    padding: 5px;
    width: 100px;
    border: 1px #ccc solid;
    border-radius: 5px;
}
</style>
