<template>
    <div ref="printContent">
        <head>
            <title>Invoice : #{{id}}</title>
        </head>
        <div>
            <p>Invoice : #{{id}}</p>
            <p>Date : {{ invoice.created_at }}</p>
            <br>
            <table style=" width: 100%; border-collapse: collapse ">
                <tr>
                    <th colspan="2" style="border: 1px solid black; padding: 8px; text-align: left" >Customer</th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left">{{ invoice.customer_name }}</th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left"></th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left"></th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left"></th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left"></th>
                </tr>
                <tr>
                    <th style="border: 1px solid black; padding: 8px; text-align: left">No</th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left">Category</th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left">Fruit</th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left">Unit</th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left">Price</th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left">Quantity</th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left">Amount</th>
                </tr>
                <tr v-for="(item, index) in buy" class="set-row" >
                    <td style="border: 1px solid black; padding: 8px; text-align: left">{{ displayIndex(index) }}</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: left">{{ item.category_name }}</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: left">{{ item.name }}</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: left">{{ item.unit }}</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: left">{{ item.price }}</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: left">{{ item.pivot.quantity }}</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: left">{{ getPrice(item.price , item.pivot.quantity) }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; text-align: left"></td>
                    <td style="border: 1px solid black; padding: 8px; text-align: left"></td>
                    <th style="border: 1px solid black; padding: 8px; text-align: left"></th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left"></th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left"></th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left">Total</th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left">{{ total }}</th>
                </tr>
            </table>
        </div>
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
            total: 0,
        };
    },
    methods: {
        async loadContent() {
            try {
                const invoiceResponse = await this.invoiceInfo(this.id);
                this.invoice = invoiceResponse.data;

                const invoiceDetailResponse = await this.invoiceDetail(this.id);
                this.buy = invoiceDetailResponse.data;


                this.total = this.buy.reduce((acc, item) => {
                    return acc + this.getPrice(item.price, item.pivot.quantity);
                }, 0);
                
                this.total = this.total.toFixed(2);
            } catch (error) {
                console.log(error);
            }
        },
    },
    watch: {
        id(newVal) {
            this.loadContent();
        }
    },
    mounted() {
        this.loadContent();
    }
};
</script>
