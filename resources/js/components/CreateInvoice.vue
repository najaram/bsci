<template>
    <div>
        <v-card flat>
            <v-card-text>
            <v-form v-model="valid" ref="invoiceForm" lazy-validation>
                <v-container>
                    <h2>Customer Information</h2>
                    <v-divider></v-divider>
                    <v-layout row wrap>
                        <v-flex xs12 sm6>
                            <v-text-field box label="Name" v-model="customer_name" :rules="customerNameRules"></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6>
                            <v-text-field box label="Address" v-model="customer_address" :rules="customerAddRules"></v-text-field>
                        </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                        <v-flex xs12 sm6>
                            <v-menu
                                    v-model="menu1"
                                    :close-on-content-click="false"
                                    full-width
                                    max-width="290"
                            >
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                            box
                                            :value="formattedDate"
                                            clearable
                                            label="Invoice date"
                                            prepend-icon="event"
                                            v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                        v-model="date1"
                                        @change="menu1 = false"
                                ></v-date-picker>
                            </v-menu>
                        </v-flex>
                        <v-flex xs12 sm6>
                            <v-text-field box label="Invoice Number" :rules="invoiceNumberRules" v-model="invoiceNumber"></v-text-field>
                        </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                        <v-flex xs12 sm6>
                            <v-menu
                                    v-model="menu2"
                                    :close-on-content-click="false"
                                    full-width
                                    max-width="290"
                            >
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                            box
                                            :value="formattedDueDate"
                                            clearable
                                            label="Invoice date"
                                            prepend-icon="event"
                                            v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                        v-model="date2"
                                        @change="menu2 = false"
                                ></v-date-picker>
                            </v-menu>
                        </v-flex>
                        <v-flex xs12 sm6>
                            <v-textarea
                                    v-model="note"
                                    :rules="noteRules"
                                    box
                                    name="input-7-4"
                                    label="Note">
                            </v-textarea>
                        </v-flex>
                    </v-layout>
                    <br>
                    <h2>Products</h2>
                    <v-divider></v-divider>
                    <v-layout row wrap>
                        <v-flex xs12 sm6>
                            <v-select
                                    box
                                    @change="getProduct"
                                    :items="products"
                                    v-model="selectedProduct"
                                    label="Product Name"
                                    item-text="name"
                                    item-value="id"
                            ></v-select>
                        </v-flex>
                        <v-flex xs12 sm6>
                            <v-text-field box label="Product Quantity" v-model="productQty"></v-text-field>
                        </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                        <v-flex xs12 sm6>
                            <v-text-field box label="Product Price" v-model="productPrice"></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6>
                            <v-text-field box label="Product Tax" v-model="productTax"></v-text-field>
                        </v-flex>
                    </v-layout>
                    <br>
                    <h2>Payment</h2>
                    <v-divider></v-divider>
                    <v-layout row wrap>
                        <v-flex xs12 sm6>
                            <v-select
                                box
                                :items="payments"
                                v-model="selectedPayment"
                                label="Payment Type"
                                item-text="label"
                                item-value="value"
                                ></v-select>
                        </v-flex>
                        <v-flex xs12 sm6>
                            <v-text-field box label="Payment Amount" v-model="paymentAmount"></v-text-field>
                        </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                        <v-flex xs12 sm12>
                            <v-btn @click="save()" :disabled="!valid" color="primary">Save</v-btn>
                        </v-flex>
                    </v-layout>
                </v-container>
                <v-snackbar v-model="snackbar" :top="y === 'top'">{{ text }}</v-snackbar>
            </v-form>
        </v-card-text>
        </v-card>
    </div>
</template>

<script>
    import axios from 'axios';
    import moment from 'moment';
    import swal from 'sweetalert';
    export default {
        name: "CreateInvoice",
        data () {
            return {
                valid: false,
                active: null,
                date1: new Date().toISOString().substr(0, 10),
                date2: new Date().toISOString().substr(0, 10),
                menu1: false,
                menu2: false,
                customer_name: '',
                customer_address: '',
                customerNameRules: [
                    (v) => !!v || 'Name required'
                ],
                customerAddRules: [
                    (v) => !!v || 'Address required'
                ],
                invoiceNumberRules: [
                    (v) => !!v || 'Invoice Number required'
                ],
                noteRules: [
                    (v) => !!v || 'Notes required'
                ],
                invoiceNumber: '',
                note: '',
                products: [],
                selectedProduct: '',
                productQty: '',
                productName: '',
                productPrice: '',
                productTax: '',
                payments: [
                    {label: 'Cash', value: 'cash'},
                    {label: 'Check', value: 'check'},
                    {label: 'Credit', value: 'credit'},
                ],
                selectedPayment: '',
                paymentAmount: '',
                snackbar: '',
                y: 'top',
                text: ''
            }
        },
        mounted() {
            this.getProducts();
            this.valid = false;
        },
        methods: {
            next () {
                const active = parseInt(this.active)
                this.active = (active < 2 ? active + 1 : 0)
            },
            getProduct() {
                axios.get('/products/'+this.selectedProduct).then((response) => {
                    const product = response.data.data;
                    this.productName = product.name;
                    this.productQty = product.quantity;
                    this.productPrice = product.price;
                    this.productTax = product.tax;
                });
            },
            getProducts() {
                axios.get('/products').then((response) => {
                    this.products = response.data.data;
                });
            },
            save() {
                const payload = {
                    customer_name: this.customer_name,
                    customer_address: this.customer_address,
                    invoice_date: moment(this.date1).format('YYYY-MM-DD'),
                    invoice_number: this.invoiceNumber,
                    invoice_due_date: moment(this.date2).format('YYYY-MM-DD'),
                    invoice_note: this.note,
                    product_name: this.productName,
                    product_qty: this.productQty,
                    product_price: this.productPrice,
                    product_tax: this.productTax,
                    payment_type: this.selectedPayment,
                    payment_amount: this.paymentAmount
                };
                axios.post('/invoice', payload).then((response) => {
                    swal({
                        title: 'Great!',
                        text: 'Successfully added an invoice',
                        icon: 'success'
                    });
                    this.$refs.invoiceForm.reset();
                })
            }
        },
        computed: {
            formattedDate() {
                return this.date1 ? moment(this.date1).format('YYYY-MM-DD') : '';
            },
            formattedDueDate() {
                return this.date2 ? moment(this.date2).format('YYYY-MM-DD') : '';
            }
        }
    }
</script>

<style scoped>

</style>
