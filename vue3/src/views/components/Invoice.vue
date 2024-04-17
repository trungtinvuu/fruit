<template>
    <div>
        <p>Invoice : #{{id}}</p>
        <p>Date : {{ invoice.created_at }}</p>
        <br>
        <table>
            <tr>
                <th colspan="2">Customer</th>
                <th >{{ invoice.customer_name }}</th>
                <th ></th>
                <th ></th>
                <th ></th>
                <th ></th>
            </tr>
            <tr>
                <th>No</th>
                <th>Category</th>
                <th>Fruit</th>
                <th>Unit</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Amount</th>
            </tr>
            <tr v-for="(item, index) in buy" >
                <td>{{ displayIndex(index) }}</td>
                <td>Apple</td>
                <th>{{ item.name }}</th>
                <th>{{ item.unit }}</th>
                <th>{{ item.price }}</th>
                <th>{{ item.pivot.quantity }}</th>
                <th>{{ getPrice(item.price , item.pivot.quantity) }}</th>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <th></th>
                <th></th>
                <th></th>
                <th>Total</th>
                <th>50</th>
            </tr>
        </table>
    </div>
</template>

<script>
import { myMixin } from '@/store/mixin';
import axiosInstance from '@/store/axiosInstance';
import Config from '@/store/config';

export default {
    props: ['id'],
    mixins: [myMixin],
    data() {
        return {
            buy: [],
            invoice : {},
        };
    },
    methods: {
        getPrice(price , quantity) {
            return price * quantity;
        },
    },
    mounted() {
        this.invoiceInfo(this.id)
            .then(response => {
                this.invoice = response.data;
                console.log(this.invoice);
            })
            .catch(error => {
                console.log(error);
            });

        this.invoiceDetail(this.id)
            .then(response => {
                this.buy = response.data;
                console.log(this.buy);
            })
            .catch(error => {
                console.log(error);
            });
    }
};
</script>


<style>
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid black;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}
</style>
