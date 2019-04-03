<template>
    <div>
        <v-container grid-list-md>
            <v-layout row wrap>
                <v-flex xs12 sm12>
                    <h2>Invoice Information</h2>
                </v-flex>
                <br>
                <br>
                <br>
            </v-layout>

            <v-layout row wrap>
                <v-flex xs12 sm6>
                    <h4>Bill To:</h4>
                    <h6>{{ invoice.customer_name }}</h6>
                </v-flex>
                <v-flex xs12 sm6>
                    <h4>Ship To:</h4>
                    <h6>{{ invoice.customer_address }}</h6>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12 sm6>
                    <h4>Invoice date:</h4>
                    <h6>{{ invoice.invoice_date }}</h6>
                </v-flex>
                <v-flex xs12 sm6>
                    <h4>Invoice due date:</h4>
                    <h6>{{ invoice.invoice_due_date }}</h6>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12 sm12>
                    <h4>Invoice number:</h4>
                    <h6>#{{ invoice.invoice_number }}</h6>
                </v-flex>
                <v-flex xs12 sm6>
                    <h4>Invoice note:</h4>
                    <h6>{{ invoice.invoice_note }}</h6>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12 sm6>
                    <h4>Product name:</h4>
                    <h6>{{ invoice.product_name }}</h6>
                </v-flex>
                <v-flex xs12 sm6>
                    <h4>Product Qty:</h4>
                    <h6>{{ invoice.product_qty }} item(s)</h6>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12 sm3>
                    <h4>Product price:</h4>
                    <h6>${{ invoice.product_price }}</h6>
                </v-flex>
                <v-flex xs12 sm3>
                    <h4>Product Tax:</h4>
                    <h6>{{ invoice.product_tax }}%</h6>
                </v-flex>
                <v-flex xs12 sm3>
                    <h4>Total Amount:</h4>
                    <h6>${{ invoice.total }}</h6>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12 sm6>
                    <h4>Payment type:</h4>
                    <h6>{{ invoice.payment_type }}</h6>
                </v-flex>
                <v-flex xs12 sm6>
                    <h4>Payment amount:</h4>
                    <h6>${{ invoice.payment_amount }}</h6>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "ViewInvoice",
        data () {
            return {
                invoice: '',
                productName: '',
                productQty: '',
                productPrice: '',
                productTax: '',
                headers: [
                    {
                        text: 'Product Name',
                        align: 'left',
                        sortable: false,
                        value: 'product_name'
                    },
                    {
                        text: 'Product Qty',
                        align: 'left',
                        sortable: false,
                        value: 'product_qty'
                    },
                    {
                        text: 'Product Price',
                        align: 'left',
                        sortable: false,
                        value: 'product_price'
                    },
                    {
                        text: 'Product Tax',
                        align: 'left',
                        sortable: false,
                        value: 'product_tax'
                    },

                ],
            }
        },
        props: {
            propInvoice: {
                required: true,
                type: String
            }
        },
        mounted () {
            this.getInvoice();
        },
        methods: {
            getInvoice() {
                axios.get('/invoice/'+this.propInvoice).then((response) => {
                    console.log(response.data.data);
                    this.invoice = response.data.data;
                })
            }
        }
    }
</script>

<style scoped>

</style>
