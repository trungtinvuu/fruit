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
            <tr v-for="(item, index) in buy" class="set-row" >
                <td>{{ displayIndex(index) }}</td>
                <td>{{ item.category_name }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.unit }}</td>
                <td>{{ item.price }}</td>
                <td>{{ item.pivot.quantity }}</td>
                <td>{{ getPrice(item.price , item.pivot.quantity) }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <th></th>
                <th></th>
                <th></th>
                <th>Total</th>
                <th>{{ total }}</th>
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
            total: 0
        };
    },
    methods: {

    },
    mounted() {
        this.invoiceInfo(this.id)
            .then(response => {
                this.invoice = response.data;
            })
            .catch(error => {
                console.log(error);
            });

        this.invoiceDetail(this.id)
            .then(response => {
                this.buy = response.data;
                this.buy.forEach(item => {
                    let value = this.getPrice(item.price , item.pivot.quantity);
                    this.total += value;
                });
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
    background: #fff;
}
</style>
